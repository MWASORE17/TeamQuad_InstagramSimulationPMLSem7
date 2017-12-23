package com.example.chyntia.simulasi_ig.view.fragment.user;

import android.os.Bundle;
import android.support.annotation.Nullable;
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
import com.example.chyntia.simulasi_ig.view.adapter.FollowersRVAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.FollowingRVAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.LoginDBAdapter;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.response.UserFollowResponse;

import java.util.HashMap;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Chyntia on 5/23/2017.
 */

public class FollowersFragment extends Fragment {
    private BottomNavigationView bottomNavigationView;
    TextView text;
    ImageView ic_left,ic_right;
    RecyclerView rv;
    Button btn;
//    LoginDBAdapter loginDBAdapter;
    SessionManager session;
    String userName;
    String token;

    public FollowersFragment() {
        // Required empty public constructor
    }

    public static FollowersFragment newInstance(String token){
        Bundle args = new Bundle();
        args.putString("TOKEN", token);
        FollowersFragment fragment = new FollowersFragment();
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        token = getArguments().getString("TOKEN");
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View _view = inflater.inflate(R.layout.fragment_followers, container, false);

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
        text.setText("Followers");

        ic_left = (ImageView) view.findViewById(R.id.icon_left);
        ic_left.setImageResource(R.drawable.ic_arrow_back_black_24dp);

        ic_right = (ImageView) view.findViewById(R.id.icon_right);
        ic_right.setImageResource(0);

        rv = (RecyclerView) view.findViewById(R.id.recycler_view);
        setupRV();

        btn = (Button) view.findViewById(R.id.btn);
    }

    private void setupRV(){
        ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
        Call<UserFollowResponse> call = apiRoute.getFollower(token);
        call.enqueue(new Callback<UserFollowResponse>() {
            @Override
            public void onResponse(Call<UserFollowResponse> call, Response<UserFollowResponse> response) {
                UserFollowResponse data = response.body();

                if(data.isStatus()){
                    FollowersRVAdapter adapter = new FollowersRVAdapter(data.getData(), getActivity().getApplication());
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
                ((MainActivity) getActivity()).onBackPressed();
            }
        });
    }
}
