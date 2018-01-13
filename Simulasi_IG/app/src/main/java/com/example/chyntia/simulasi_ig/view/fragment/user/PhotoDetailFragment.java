package com.example.chyntia.simulasi_ig.view.fragment.user;

import android.os.Bundle;
import android.support.design.widget.BottomNavigationView;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.activity.MainActivity;
import com.example.chyntia.simulasi_ig.view.adapter.LoginDBAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.TabGridRVAdapter;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.model.PostDetail;
import com.example.chyntia.simulasi_ig.view.network.response.CResponse;
import com.example.chyntia.simulasi_ig.view.network.response.PostDetailResponse;
import com.example.chyntia.simulasi_ig.view.network.response.PostsResponse;
import com.example.chyntia.simulasi_ig.view.utilities.DatetimeUtils;
import com.like.LikeButton;
import com.like.OnLikeListener;
import com.squareup.picasso.Picasso;

import java.io.File;
import java.text.ParseException;
import java.util.HashMap;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Chyntia on 6/16/2017.
 */

public class PhotoDetailFragment extends Fragment{
    private BottomNavigationView bottomNavigationView;
    TextView text, user_name, time, caption, location, username_caption, count_likes, view_comment;
    ImageView ic_left, ic_right, ic_send, photo, pp, comment;
    TabGridRVAdapter tabGridRVAdapter;
//    LoginDBAdapter loginDBAdapter;
    SessionManager session;
    String userName;
    LikeButton like;
    int posting_id;
    private static final int SECOND_MILLIS = 1000;
    private static final int MINUTE_MILLIS = 60 * SECOND_MILLIS;
    private static final int HOUR_MILLIS = 60 * MINUTE_MILLIS;
    private static final int DAY_MILLIS = 24 * HOUR_MILLIS;

    private PostDetail post;

    public PhotoDetailFragment() {
        // Required empty public constructor
    }

    public static PhotoDetailFragment newInstance() {
        return new PhotoDetailFragment();
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        posting_id = getArguments().getInt("POSITION");
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View _view = inflater.inflate(R.layout.fragment_photo_detail, container, false);

        init(_view);
        event();

        return _view;
    }

    private void init(final View view) {

        session = new SessionManager(getContext());
        final HashMap<String, String> user = session.getUserDetails();

        userName = user.get(SessionManager.KEY_USERNAME);

        text = (TextView) view.findViewById(R.id.toolbar_title);
        text.setText("Photo");

        ic_left = (ImageView) view.findViewById(R.id.icon_left);
        ic_left.setImageResource(R.drawable.ic_arrow_back_black_24dp);

        ic_right = (ImageView) view.findViewById(R.id.icon_right);
        ic_right.setImageResource(0);

        pp = (ImageView) view.findViewById(R.id.pp_photo_detail);
        user_name = (TextView) view.findViewById(R.id.nama_photo_detail);
        photo = (ImageView) view.findViewById(R.id.photo_area_photo_detail);
        time = (TextView) view.findViewById(R.id.time_photo_detail);
        caption = (TextView) view.findViewById(R.id.photo_caption_photo_detail);
        username_caption = (TextView) view.findViewById(R.id.username_caption_photo_detail);
        like = (LikeButton) view.findViewById(R.id.icon_like_photo_detail);
        count_likes = (TextView) view.findViewById(R.id.count_likes_photo_detail);
        location = (TextView) view.findViewById(R.id.location_photo_detail);
        /**
         * Retrofit
         * */
        ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
        Call<PostDetailResponse> call = apiRoute.getPostDetail(user.get(SessionManager.KEY_USERNAME), posting_id);
        call.enqueue(new Callback<PostDetailResponse>() {
            @Override
            public void onResponse(Call<PostDetailResponse> call, Response<PostDetailResponse> response) {
                PostDetailResponse data = response.body();

                if(data.isStatus()){
                    post = data.getData();

                    if(post.getImagePath() != ""){
                        Picasso
                                .with(getContext())
                                .load(ApiRetrofit.URL + post.getUserImagePath())
                                .resize(dpToPx(20), dpToPx(20))
                                .centerCrop()
                                .error(R.drawable.ic_account_circle_black_24dp)
                                .into(pp);
                    }
                    else
                        pp.setImageResource(R.drawable.ic_account_circle_black_24dp);

                    user_name.setText(post.getUserName());
                    Picasso
                            .with(getContext())
                            .load(ApiRetrofit.URL + post.getImagePath())
                            .resize(dpToPx(80), dpToPx(80))
                            .centerCrop()
                            .error(R.drawable.ic_account_circle_black_128dp)
                            .into(photo);

                    try {
                        time.setText(getTimeAgo(DatetimeUtils.stringToDate(post.getCreatedOn()).getTime()));
                    } catch (ParseException e) {
                        e.printStackTrace();
                    }

                    if(post.getContent() == "")
                        caption.setVisibility(View.GONE);

                    else {
                        username_caption.setVisibility(View.VISIBLE);
                        username_caption.setText(post.getUserName());
                        caption.setVisibility(View.VISIBLE);
                        caption.setText(post.getContent());
                    }

                    if(post.getLocation() == "")
                        location.setVisibility(View.GONE);

                    else {
                        location.setVisibility(View.VISIBLE);
                        location.setText(post.getLocation());
                    }


                    if(post.getIsUnlike() == 0) {
                        like.setLiked(true);
                        like.setLikeDrawableRes(R.drawable.ic_heart_red);
                    }

                    else {
                        like.setLiked(false);
                        like.setUnlikeDrawableRes(R.drawable.ic_heart_outline_grey);
                    }

                    if(post.getTotalLikes() > 0){
                        count_likes.setVisibility(View.VISIBLE);

                        if(post.getTotalLikes() == 0)
                            count_likes.setVisibility(View.GONE);

                        else if(post.getTotalLikes() == 1)
                            count_likes.setText(String.valueOf(post.getTotalLikes() +" like"));

                        else
                            count_likes.setText(String.valueOf(post.getTotalLikes() +" likes"));
                    }

                    if(post.getTotalComment() != 0) {
                        view_comment.setVisibility(View.VISIBLE);
                        if(post.getTotalComment() == 0){
                            view_comment.setVisibility(View.GONE);
                        }
                        else if(post.getTotalComment() == 1) {
                            view_comment.setText("View 1 comment");
                            view_comment.setOnClickListener(new View.OnClickListener() {
                                @Override
                                public void onClick(View v) {
                                    int position = post.getPostID();
                                    UserCommentFragment ucf = new UserCommentFragment();
                                    final Bundle args = new Bundle();
                                    args.putInt("POSITION", position);
                                    ucf.setArguments(args);
                                    ((MainActivity) v.getContext()).changefragment(ucf, "UserComment");
                                }
                            });
                        }

                        else{
                            view_comment.setText("View all "+String.valueOf(post.getTotalComment() + " comments"));
                            view_comment.setOnClickListener(new View.OnClickListener() {
                                @Override
                                public void onClick(View v) {
                                    int position = post.getPostID();
                                    UserCommentFragment ucf = new UserCommentFragment();
                                    final Bundle args = new Bundle();
                                    args.putInt("POSITION", position);
                                    ucf.setArguments(args);
                                    ((MainActivity) v.getContext()).changefragment(ucf, "UserComment");
                                }
                            });
                        }
                    }
                }
                else{

                }
            }

            @Override
            public void onFailure(Call<PostDetailResponse> call, Throwable t) {
//                Log.e("ERR", String.valueOf(t.getMessage()));
            }
        });



        like.setOnLikeListener(new OnLikeListener() {
            @Override
            public void liked(LikeButton likeButton) {
                count_likes.setVisibility(View.VISIBLE);
                String token = session.getUserDetails().get(SessionManager.KEY_USERNAME);
                /** Insert Like*/
                ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
                Call<CResponse> call = apiRoute.postLike(token, post.getPostID());
                call.enqueue(new Callback<CResponse>() {
                    @Override
                    public void onResponse(Call<CResponse> call, Response<CResponse> response) {
                        CResponse data = response.body();

                        if(data.isStatus()){
//                            Log.i("Success IG", data.getMessage());
                        }
                        else{
//                            Log.e("Failed IG", data.getMessage());
                        }
                    }

                    @Override
                    public void onFailure(Call<CResponse> call, Throwable t) {
//                        Log.e("ERR", String.valueOf(t.getMessage()));
                    }
                });

                /** Insert Notif*/

                post.setTotalLikes(post.getTotalLikes()+ 1);
                int totalLikes = post.getTotalLikes();
                if (totalLikes == 0)
                    count_likes.setVisibility(View.GONE);

                else if (totalLikes == 1)
                    count_likes.setText(1 + " like");

                else
                    count_likes.setText(totalLikes + " likes");
            }

            @Override
            public void unLiked(LikeButton likeButton) {
                count_likes.setVisibility(View.VISIBLE);
                String token = session.getUserDetails().get(SessionManager.KEY_USERNAME);
                ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
                Call<CResponse> call = apiRoute.postUnLike(token, post.getPostID());
                call.enqueue(new Callback<CResponse>() {
                    @Override
                    public void onResponse(Call<CResponse> call, Response<CResponse> response) {
                        CResponse data = response.body();

                        if(data.isStatus()){
//                            Log.i("Success IG", data.getMessage());
                        }
                        else{
//                            Log.e("Failed IG", data.getMessage());
                        }
                    }

                    @Override
                    public void onFailure(Call<CResponse> call, Throwable t) {
//                        Log.e("ERR", String.valueOf(t.getMessage()));
                    }
                });

                post.setTotalLikes(post.getTotalLikes()-1);
                int totalLikes = post.getTotalLikes();
                if (totalLikes == 0)
                    count_likes.setVisibility(View.GONE);

                else if (totalLikes == 1)
                    count_likes.setText(1 + " like");

                else
                    count_likes.setText(totalLikes + " likes");
            }
        });

        comment = (ImageView) view.findViewById(R.id.icon_comment_photo_detail);
        view_comment = (TextView) view.findViewById(R.id.comments_photo_detail);
        comment.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                int position = post.getPostID();
                UserCommentFragment ucf = new UserCommentFragment();
                final Bundle args = new Bundle();
                args.putInt("POSITION", position);
                ucf.setArguments(args);
                ((MainActivity) v.getContext()).changefragment(ucf, "UserComment");
            }
        });
    }

    private int dpToPx(int dp)
    {
        float density = getContext().getResources().getDisplayMetrics().density;
        return Math.round((float)dp * density);
    }

    private void event() {
        ic_left.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ((MainActivity) getActivity()).onBackPressed();
            }
        });
    }

    public static String getTimeAgo(long time) {
        if (time < 1000000000000L) {
            // if timestamp given in seconds, convert to millis
            time *= 1000;
        }

        long now = System.currentTimeMillis();
        if (time > now || time <= 0) {
            return null;
        }

        // TODO: localize
        final long diff = now - time;
        if (diff < MINUTE_MILLIS) {
            return "just now";
        } else if (diff < 2 * MINUTE_MILLIS) {
            return "a minute ago";
        } else if (diff < 50 * MINUTE_MILLIS) {
            return diff / MINUTE_MILLIS + " minutes ago";
        } else if (diff < 90 * MINUTE_MILLIS) {
            return "an hour ago";
        } else if (diff < 24 * HOUR_MILLIS) {
            return diff / HOUR_MILLIS + " hours ago";
        } else if (diff < 48 * HOUR_MILLIS) {
            return "yesterday";
        } else {
            return diff / DAY_MILLIS + " days ago";
        }
    }

}
