package com.example.chyntia.simulasi_ig.view.fragment.user;

import android.graphics.Color;
import android.os.Bundle;
import android.support.design.widget.TabLayout;
import android.support.v4.app.Fragment;
import android.support.v4.view.ViewPager;
import android.support.v4.widget.SwipeRefreshLayout;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.activity.MainActivity;
import com.example.chyntia.simulasi_ig.view.adapter.LoginDBAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.ProfileVPAdapter;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.model.UserProfile;
import com.example.chyntia.simulasi_ig.view.network.model.UserProfileSearch;
import com.example.chyntia.simulasi_ig.view.network.response.CResponse;
import com.example.chyntia.simulasi_ig.view.network.response.PostsResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserProfileResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserProfileSearchResponse;
import com.squareup.picasso.Picasso;

import java.io.File;
import java.util.HashMap;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static android.R.attr.data;

/**
 * Created by Chyntia on 6/19/2017.
 */

public class UserProfileFragment extends Fragment {
    public static TextView profile_username;
    TextView total_following, total_followers, total_following_text, total_followers_text, total_post, total_post_text;
    ImageView ic_left, ic_right, ic_friend_recommendation;
    Button edit_btn, btn_follow;
    public static ImageView profile_pp;
    TabLayout tabLayoutProfile;
    private int tabIcons[] = new int[] { R.drawable.tab_profile_icon_grid_states, R.drawable.tab_profile_icon_list_states};
    SwipeRefreshLayout mSwipeRefreshLayout;
    private boolean isButtonClicked = false;
    SessionManager session;
    UserProfileSearch user;
    ViewPager viewPagerProfile;
//    LoginDBAdapter loginDBAdapter;
    String userName;
    int username_profile;

    public UserProfileFragment() {
        // Required empty public constructor
    }

    public static UserProfileFragment newInstance() {
        return new UserProfileFragment();
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        username_profile = getArguments().getInt("USERNAME");
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View _view = inflater.inflate(R.layout.fragment_profile, container, false);

        init(_view);
        event();

        return _view;
    }

    private void init(final View view) {

        session = new SessionManager(getContext());
        HashMap<String, String> user12 = session.getUserDetails();

        // name
//        userName = user.get(SessionManager.KEY_USERNAME);

        profile_username = (TextView) view.findViewById(R.id.toolbar_title);
//        profile_username.setText(username_profile);

        ic_left = (ImageView) view.findViewById(R.id.icon_left);
        ic_left.setImageResource(R.drawable.ic_arrow_back_black_24dp);

        ic_right = (ImageView) view.findViewById(R.id.icon_right);
        ic_right.setVisibility(View.GONE);

        edit_btn = (Button) view.findViewById(R.id.btn_edit);

        btn_follow = (Button) view.findViewById(R.id.profile_btn_follow);

       /* if(username_profile.equals(userName)){
            edit_btn.setVisibility(View.VISIBLE);
            btn_follow.setVisibility(View.GONE);
            edit_btn.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    ((MainActivity) getActivity()).addfragment(new EditProfileFragment(), "EditProfile");
                }
            });
        }
        else
        {*/
            edit_btn.setVisibility(View.GONE);
            btn_follow.setVisibility(View.VISIBLE);
//        }

        total_post = (TextView) view.findViewById(R.id.total_posts);
        total_post_text = (TextView) view.findViewById(R.id.total_posts_text);

        total_followers = (TextView) view.findViewById(R.id.total_followers);
        total_followers_text = (TextView) view.findViewById(R.id.total_followers_text);

        total_following = (TextView) view.findViewById(R.id.total_following);
        total_following_text = (TextView) view.findViewById(R.id.total_following_text);

        ic_friend_recommendation = (ImageView) view.findViewById(R.id.icon_friend_recommendation);
        ic_friend_recommendation.setVisibility(View.GONE);

        profile_pp = (ImageView) view.findViewById(R.id.profile_photo);
        updateProfPic();

        viewPagerProfile = (ViewPager) view.findViewById(R.id.viewpager_profile);
//        viewPagerProfile.setVisibility(View.GONE);

        tabLayoutProfile = (TabLayout) view.findViewById(R.id.sliding_tabs_profile);

        /*if(loginDBAdapter.check_TBPosting().equals("EMPTY") || loginDBAdapter.check_TBPostingProfile(loginDBAdapter.getID(username_profile)).equals("NOT EXIST")) {
            changefragment(new ProfileViewFragment(), "ProfileView");
            viewPagerProfile.setVisibility(view.GONE);
*//*
            disable_tablayout();
            tabLayoutProfile.setSelectedTabIndicatorColor(0);
            setupTabIcons();*//*
        }

        else{
            UserTabGridFragment utgf = new UserTabGridFragment();
            final Bundle args = new Bundle();
            args.putString("USERNAME", username_profile);
            utgf.setArguments(args);
            changefragment(utgf, "UserTabGrid");
        }*/
    }

    private void setupTabIcons() {
        tabLayoutProfile.getTabAt(0).setIcon(tabIcons[0]);
        tabLayoutProfile.getTabAt(1).setIcon(tabIcons[1]);
    }

    private int dpToPx(int dp)
    {
        float density = getContext().getResources().getDisplayMetrics().density;
        return Math.round((float)dp * density);
    }

    private void event() {
        ic_left.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v) {

                ((MainActivity) getActivity()).onBackPressed();

            }
        });

        /**
         * !!DELETE
         * */
        /*if(loginDBAdapter.check_TBPosting().equals("EMPTY")){

            total_post.setEnabled(false);

            total_post_text.setEnabled(false);
        }
        else{
            total_post.setText(String.valueOf(loginDBAdapter.getPostingProfile(loginDBAdapter.getID(username_profile)).size()));

            if(loginDBAdapter.getPostingProfile(loginDBAdapter.getID(username_profile)).size()>1)
                total_post_text.setText("posts");

            else
                total_post_text.setText("post");
        }

        if(loginDBAdapter.check_TBFollow().equals("EMPTY"))
        {
            total_following.setEnabled(false);

            total_following_text.setEnabled(false);

            total_followers.setEnabled(false);

            total_followers_text.setEnabled(false);
        }

        else {
            if (loginDBAdapter.checkFollowing().contains(loginDBAdapter.getID(username_profile))) {

                total_following.setEnabled(true);

                String totalFollowing = "" + loginDBAdapter.getAllFollowing(loginDBAdapter.getID(username_profile)).size();
                total_following.setText(totalFollowing);

                total_following.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        ((MainActivity) getActivity()).addfragment(new FollowingFragment(), "Following");
                    }
                });

                total_following_text.setEnabled(true);

                total_following_text.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        ((MainActivity) getActivity()).addfragment(new FollowingFragment(), "Following");
                    }
                });
            } else {
                total_following.setEnabled(false);

                total_following_text.setEnabled(false);
            }

            if (loginDBAdapter.checkFollowers().contains(loginDBAdapter.getID(username_profile))) {

                total_followers.setEnabled(true);

                String totalFollowers = "" + loginDBAdapter.getAllFollowers(loginDBAdapter.getID(username_profile)).size();
                total_followers.setText(totalFollowers);

                total_followers.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        ((MainActivity) getActivity()).addfragment(new FollowersFragment(), "Followers");
                    }
                });

                total_followers_text.setEnabled(true);

                total_followers_text.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        ((MainActivity) getActivity()).addfragment(new FollowersFragment(), "Followers");
                    }
                });
            } else {
                total_followers.setEnabled(false);

                total_followers_text.setEnabled(false);
            }
        }*/

        btn_follow.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                String token = session.getUserDetails().get(SessionManager.KEY_USERNAME);
                if(user.getIsFollowing() == 0)
                    isButtonClicked = !isButtonClicked;

                /** FOLLOW */
                if(isButtonClicked){
                    ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
                    Call<CResponse> call = apiRoute.follow(token, user.getUserName());
                    call.enqueue(new Callback<CResponse>() {
                        @Override
                        public void onResponse(Call<CResponse> call, Response<CResponse> response) {
                            CResponse data = response.body();

                            if(data.isStatus()){
                                user.setIsFollowing(1);
                            }
                        }

                        @Override
                        public void onFailure(Call<CResponse> call, Throwable t) {

                        }
                    });

                    btn_follow.setText("Following");
                    btn_follow.setTextColor(Color.BLACK);
                    v.setBackgroundResource(R.drawable.btn_following);
                }

                else{
                    ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
                    Call<CResponse> call = apiRoute.unFollow(token, user.getUserName());
                    call.enqueue(new Callback<CResponse>() {
                        @Override
                        public void onResponse(Call<CResponse> call, Response<CResponse> response) {
                            CResponse data = response.body();

                            if(data.isStatus()){
                                user.setIsFollowing(0);
                            }
                        }

                        @Override
                        public void onFailure(Call<CResponse> call, Throwable t) {

                        }
                    });

                    btn_follow.setText("Follow");
                    btn_follow.setTextColor(Color.WHITE);
                    v.setBackgroundResource(R.drawable.btn_follow);
                }

            }
        });
    }

    public void changefragment(Fragment fragment, String tag) {
        getActivity().getSupportFragmentManager().beginTransaction().replace(R.id.profile_content, fragment, tag).commit();
    }

    private void updateProfPic(){
        final String token = session.getUserDetails().get(SessionManager.KEY_USERNAME);

        ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
        Call<UserProfileSearchResponse> call = apiRoute.GetSearchUserProfile(token, username_profile);
        call.enqueue(new Callback<UserProfileSearchResponse>() {
            @Override
            public void onResponse(Call<UserProfileSearchResponse> call, Response<UserProfileSearchResponse> response) {
                final UserProfileSearchResponse data = response.body();

                if(data.isStatus()){
                    user = data.getData();
                    profile_username.setText(user.getUserName());
                    if(user.getImagePath() != ""){
                        Picasso
                                .with(getContext())
                                .load(ApiRetrofit.URL + data.getData().getImagePath())
                                .resize(dpToPx(80), dpToPx(80))
                                .centerCrop()
                                .into(profile_pp);
                    }
                    else{
                        profile_pp.setImageResource(R.drawable.ic_account_circle_black_128dp);
                    }

                    /**
                     * User TOTAL POST
                     */
                    if(user.getTotalPosts() == 0){

                        total_post.setEnabled(false);

                        total_post_text.setEnabled(false);
                    }
                    else{
                        total_post.setText(String.valueOf(user.getTotalPosts()));

                        if(user.getTotalPosts()>1)
                            total_post_text.setText("posts");

                        else
                            total_post_text.setText("post");
                    }

                    /**
                     * User FOLLOWER
                     */
                    if(user.getTotalFollowers() == 0)
                    {
                        total_followers.setEnabled(false);
                        total_followers_text.setEnabled(false);
                    }
                    else{

                        total_followers.setEnabled(true);

                        String totalFollowers = "" + user.getTotalFollowers();
                        total_followers.setText(totalFollowers);

                        total_followers.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                ((MainActivity) getActivity()).addfragment(FollowersFragment.newInstance(data.getData().getToken()), "Followers");
                            }
                        });

                        total_followers_text.setEnabled(true);

                        total_followers_text.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                ((MainActivity) getActivity()).addfragment(FollowersFragment.newInstance(data.getData().getToken()), "Followers");
                            }
                        });
                    }

                    if(user.getTotalFollowing() == 0){
                        total_following.setEnabled(false);
                        total_following_text.setEnabled(false);
                    }
                    else{
                        total_following.setEnabled(true);

                        String totalFollowing = "" + user.getTotalFollowing();
                        total_following.setText(totalFollowing);

                        total_following.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                ((MainActivity) getActivity()).addfragment(FollowingFragment.newInstance(data.getData().getToken()), "Following");
                            }
                        });

                        total_following_text.setEnabled(true);

                        total_following_text.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                ((MainActivity) getActivity()).addfragment(FollowingFragment.newInstance(data.getData().getToken()), "Following");
                            }
                        });
                    }

                    if(user.getIsFollowing() == 1) {
                        btn_follow.setText("Following");
                        btn_follow.setTextColor(Color.BLACK);
                        btn_follow.setBackgroundResource(R.drawable.btn_following);
                    }
                    else{
                        btn_follow.setText("Follow");
                        btn_follow.setTextColor(Color.WHITE);
                        btn_follow.setBackgroundResource(R.drawable.btn_follow);
                    }

                    Log.d("tes_post", user.getToken());


                            if(user.getTotalPosts() >0){
                                viewPagerProfile.setAdapter(new ProfileVPAdapter(getChildFragmentManager(), user.getToken()));
                                tabLayoutProfile.setupWithViewPager(viewPagerProfile);
                                setupTabIcons();
                            }
                            else{
                                changefragment(new ProfileViewFragment(), "ProfileView");
                                viewPagerProfile.setVisibility(View.GONE);
                                Log.e("user post", data.getMessage());
                            }

                            /*if(data.isStatus()){
                                UserTabGridFragment utgf = new UserTabGridFragment();
                                final Bundle args = new Bundle();
                                args.putString("USERNAME", user.getToken());
                                utgf.setArguments(args);
                                changefragment(utgf, "UserTabGrid");
                            }
                            else{
                                changefragment(new ProfileViewFragment(), "ProfileView");
                                viewPagerProfile.setVisibility(View.GONE);
                                tabLayoutProfile.setSelectedTabIndicatorColor(0);
                                setupTabIcons();
                                Log.e("user post", data.getMessage());
                            }*/


                }
                else{
                    Log.d("Error", data.getMessage());
                    profile_pp.setImageResource(R.drawable.ic_account_circle_black_128dp);
                }
            }

            @Override
            public void onFailure(Call<UserProfileSearchResponse> call, Throwable t) {
                Log.e("ERR", String.valueOf(t.getMessage()));                profile_pp.setImageResource(R.drawable.ic_account_circle_black_128dp);
            }
        });

        /*if(loginDBAdapter.checkProfPic(loginDBAdapter.getID(username_profile))!=null){
            Picasso
                    .with(getContext())
                    .load(new File(loginDBAdapter.getUserProfPic(loginDBAdapter.getID(username_profile))))
                    .resize(dpToPx(80), dpToPx(80))
                    .centerCrop()
                    .error(R.drawable.ic_account_circle_black_128dp)
                    .into(profile_pp);
        }
        else
            profile_pp.setImageResource(R.drawable.ic_account_circle_black_128dp);*/
    }
}
