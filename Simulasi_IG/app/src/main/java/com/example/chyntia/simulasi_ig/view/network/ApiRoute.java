package com.example.chyntia.simulasi_ig.view.network;

import com.example.chyntia.simulasi_ig.view.network.response.CResponse;
import com.example.chyntia.simulasi_ig.view.network.response.FeedResponse;
import com.example.chyntia.simulasi_ig.view.network.response.LoginResponse;
import com.example.chyntia.simulasi_ig.view.network.response.PostResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserResponse;

import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Path;

/**
 * Created by Vinixz on 10/3/2017.
 */

public interface ApiRoute {

    @FormUrlEncoded
    @POST("Getaccount")
    Call<UserResponse> getUserAccount(@Field("token") String token);

    @FormUrlEncoded
    @POST("addPost")
    Call<CResponse> addPost(
            @Field("token") String token,
            @Field("image") String image,
            @Field("Location") String location,
            @Field("Content") String content
    );

    @GET("getFeeds/{Token}")
    Call<FeedResponse> getTimelinePost(@Path("Token") String token);

    @FormUrlEncoded
    @POST("postlike")
    Call<CResponse> postLike(@Field("token") String token, @Field("id") int postID);

   /* @GET("")
    Call<PostResponse> getUserPosts();

    @GET("")
    Call<FollowerResponse> getUserFollower();

    @GET("")
    Call<FollowingResponse> getUserFollowing();*/

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
