package com.example.chyntia.simulasi_ig.view.network;

import com.example.chyntia.simulasi_ig.view.network.model.Notif;
import com.example.chyntia.simulasi_ig.view.network.model.PostDetail;
import com.example.chyntia.simulasi_ig.view.network.response.CResponse;
import com.example.chyntia.simulasi_ig.view.network.response.CommentResponse;
import com.example.chyntia.simulasi_ig.view.network.response.NotifResponse;
import com.example.chyntia.simulasi_ig.view.network.response.PostDetailResponse;
import com.example.chyntia.simulasi_ig.view.network.response.PostsResponse;
import com.example.chyntia.simulasi_ig.view.network.response.LoginResponse;
import com.example.chyntia.simulasi_ig.view.network.response.SearchResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserFollowResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserProfileResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserProfileSearchResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserResponse;

import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Path;

import static android.R.attr.path;
import static com.example.chyntia.simulasi_ig.R.string.username;

/**
 * Created by Vinixz on 10/3/2017.
 */

public interface ApiRoute {

    @FormUrlEncoded
    @POST("Getaccount")
    Call<UserResponse> getUserAccount(@Field("token") String token);


    /** PROFILE ========= */
    @GET("GetSearchUserProfile/{token}/{user_id}")
    Call<UserProfileSearchResponse> GetSearchUserProfile(@Path("token") String token, @Path("user_id") int user_id);

    @FormUrlEncoded
    @POST("GetUserProfile")
    Call<UserProfileResponse> GetUserProfile(@Field("token") String token);
    /** ================== S */


    @GET("getPostUser/{token}")
    Call<PostsResponse> getAccountPosts(@Path("token") String token);

    /** FOLLOW ========== */
    @FormUrlEncoded
    @POST("follow")
    Call<CResponse> follow(@Field("token") String token, @Field("tousername") String username);

    @FormUrlEncoded
    @POST("unfollow")
    Call<CResponse> unFollow(@Field("token") String token, @Field("tousername") String username);

    @GET("getFollower/{token}")
    Call<UserFollowResponse> getFollower(@Path("token") String token);

    @GET("getFollowing/{token}")
    Call<UserFollowResponse> getFollowing(@Path("token") String token);

    @GET("getRecommendation/{token}")
    Call<UserFollowResponse> getRecommendation(@Path("token") String token);

    @GET("getNotifYou/{token}")
    Call<NotifResponse> getNotif(@Path("token") String token);

    @GET("getFollowingNotif/{token}")
    Call<NotifResponse> getNotifFollowing(@Path("token") String token);

    /** ================= */

    /** COMMENT */
    @FormUrlEncoded
    @POST("GetComment")
    Call<CommentResponse> getComment(@Field("token") String token, @Field("id") int post_id);

    @FormUrlEncoded
    @POST("InsertComment")
    Call<CResponse> AddComment(@Field("token") String token, @Field("id") int post_id, @Field("content") String content);

    /**
     * Search
     * */
    @GET("searchuser/{token}/{username}")
    Call<SearchResponse> searchUser(@Path("token") String token, @Path("username") String username);

    /**
     * POST : ADD
     **/
    @FormUrlEncoded
    @POST("addPost")
    Call<CResponse> addPost(
            @Field("token") String token,
            @Field("image") String image,
            @Field("Location") String location,
            @Field("Content") String content
    );

    /**
     * TIMELINE
     * */
    @GET("getFeeds/{Token}")
    Call<PostsResponse> getTimelinePost(@Path("Token") String token);

    /**
     * POST : Detail
     * */
    @GET("getPostDetail/{Token}/{id}")
    Call<PostDetailResponse> getPostDetail(@Path("Token") String token, @Path("id") int id);

    /** LIKE*/
    @FormUrlEncoded
    @POST("postlike")
    Call<CResponse> postLike(@Field("token") String token, @Field("id") int postID);

    /** LIKE*/
    @FormUrlEncoded
    @POST("postunlike")
    Call<CResponse> postUnLike(@Field("token") String token, @Field("id") int postID);

   /* @GET("")
    Call<PostDetail> getUserPosts();

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
            @Field("Name") String fullname,
            @Field("UserName") String username,
            @Field("Password") String password,
            @Field("RPassword") String rpassword,
            @Field("Email") String email
    );

}
