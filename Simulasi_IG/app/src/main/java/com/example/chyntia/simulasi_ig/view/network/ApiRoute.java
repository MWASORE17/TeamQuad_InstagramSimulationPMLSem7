package com.example.chyntia.simulasi_ig.view.network;

import com.example.chyntia.simulasi_ig.view.model.entity.User;
import com.example.chyntia.simulasi_ig.view.network.response.CResponse;
import com.example.chyntia.simulasi_ig.view.network.response.LoginResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserResponse;
import com.google.gson.JsonObject;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Headers;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Path;

/**
 * Created by Vinixz on 10/3/2017.
 */

public interface ApiRoute {

    @GET("GetUserByToken/{Token}")
    Call<UserResponse> getUserByToken(@Path("Token") String token);

    @FormUrlEncoded
    @POST("CheckLogin")
    Call<LoginResponse> login(@Field("UserName") String username, @Field("Password") String password);

    @FormUrlEncoded
    @POST("postRegisterUser")
    Call<CResponse> register(
            @Field("UserName") String username,
            @Field("Password") String password,
            @Field("RPassword") String rpassword,
            @Field("Email") String email
    );

}
