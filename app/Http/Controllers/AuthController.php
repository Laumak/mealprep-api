<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use App\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $messages = [
            "email.unique" => "Antamasi sähköpostiosoite on jo käytössä toisellä käyttäjällä."
        ];

        $validator = Validator::make($request->user, [
            "email" => "unique:users",
        ], $messages);

        if($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()->first("email"),
                "error" => "email_already_in_use"
            ], 422);
        }

        // User details
        $name     = $request->user["name"];
        $email    = $request->user["email"];
        $password = bcrypt($request->user["password"]);

        $user = User::create([
            "name"     => $name,
            "email"    => $email,
            "password" => $password,
        ]);

        // Try to generate a token for the found user. Throw if failed.
        try {
            $token = JWTAuth::fromUser($user);
        } catch(JWTException $e) {
            Log::error("Could not generate a token for the given user: " . $user->email);

            return response()->json([
                "error"   => "token_create_failed",
                "message" => "Could not create a token for the given user"
            ], 500);
        }

        Log::info("Confirmation email succesfully sent to address: " . $email);

        return response()->json([
            "message" => "User account created succesfully",
            "user"    => $user,
            "token"   => $token,
        ], 201);
    }

    public function authenticate(Request $request) {
        // grab credentials from the request
        $credentials = $request->only("email", "password");
        $token       = $token = JWTAuth::attempt($credentials);

        try {
            // Attempt to verify the credentials and create a token for the user.
            if(!$token) {
                return response()->json([
                    "error" => "invalid_credentials"
                ], 401);
            }
        } catch(JWTException $e) {
            // Something went wrong while attempting to encode the token.
            return response()->json([
                "error" => "could_not_create_token"
            ], 500);
        }

        // All good so find the associated user...
        $user = User::where("email", $request->email)->first();

        // ...and and return the token and user object to the client.
        return response()->json([
            "token" => $token,
            "user"  => $user,
        ], 200);
    }

    public function checkAuthStatus() {
        $user = JWTAuth::parseToken()->authenticate();
        try {
            if(!$user) {
                return response()->json(["user_not_found"], 404);
            }
        } catch (TokenExpiredException $e) {

            return response()->json([
                "token_expired"
            ], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json([
                "token_invalid"
            ], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json([
                "token_absent"
            ], $e->getStatusCode());
        }

        // The token is valid and the claims are valid.
        return response()->json([
            "user" => $user
        ], 200);
    }
}
