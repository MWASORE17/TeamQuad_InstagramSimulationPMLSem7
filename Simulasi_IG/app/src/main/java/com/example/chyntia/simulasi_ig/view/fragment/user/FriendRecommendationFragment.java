package com.example.chyntia.simulasi_ig.view.fragment.user;

import android.content.pm.PackageInstaller;
import android.os.Bundle;
import android.support.design.widget.BottomNavigationView;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.activity.MainActivity;
import com.example.chyntia.simulasi_ig.view.adapter.FriendRecommendationRVAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.LoginDBAdapter;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.response.UserFollowResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserProfileResponse;

import java.util.HashMap;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Chyntia on 5/24/2017.
 */

public class FriendRecommendationFragment extends Fragment {
    private BottomNavigationView bottomNavigationView;
    TextView text;
    ImageView ic_left,ic_right;
    RecyclerView rv;
    Button btn;
//    LoginDBAdapter loginDBAdapter;
    SessionManager session;
    String userName;

    public FriendRecommendationFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View _view = inflater.inflate(R.layout.fragment_friend_recommendation, container, false);

        init(_view);
        setupRV();
        event();

        return _view;
    }

    private void init(View view) {

        session = new SessionManager(getContext());
        HashMap<String, String> user = session.getUserDetails();

        userName = user.get(SessionManager.KEY_USERNAME);

        text = (TextView) view.findViewById(R.id.toolbar_title);
        text.setText("Friend Recommendations");

        ic_left = (ImageView) view.findViewById(R.id.icon_left);
        ic_left.setImageResource(R.drawable.ic_arrow_back_black_24dp);

        ic_right = (ImageView) view.findViewById(R.id.icon_right);
        ic_right.setImageResource(0);

        rv = (RecyclerView) view.findViewById(R.id.recycler_view);

        btn = (Button) view.findViewById(R.id.btn);
    }

    private void setupRV(){
        String token = session.getUserDetails().get(SessionManager.KEY_USERNAME);
        ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
        Call<UserFollowResponse> call = apiRoute.getRecommendation(token);
        call.enqueue(new Callback<UserFollowResponse>() {
            @Override
            public void onResponse(Call<UserFollowResponse> call, Response<UserFollowResponse> response) {
                UserFollowResponse data = response.body();

                if(data.isStatus()){
                    FriendRecommendationRVAdapter adapter = new FriendRecommendationRVAdapter(data.getData(), getActivity().getApplication());
                    rv.setAdapter(adapter);
                    rv.setLayoutManager(new LinearLayoutManager(getActivity().getApplicationContext()));
                }
            }

            @Override
            public void onFailure(Call<UserFollowResponse> call, Throwable t) {

            }
        });
    }

    private void event() {
        ic_left.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ((MainActivity) getActivity()).changefragment(new ProfileFragment(), "Profile");
            }
        });
    }
}