package com.example.chyntia.simulasi_ig.view.fragment.user;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.adapter.FriendRecommendationRVAdapter;
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
 * Created by Chyntia on 6/5/2017.
 */

public class TabYouViewFragment extends Fragment {
    TextView text;
    RecyclerView rv;
    Button btn;
    LoginDBAdapter loginDBAdapter;
    SessionManager session;
    String userName;

    public TabYouViewFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View _view = inflater.inflate(R.layout.fragment_tab_you_view, container, false);

        init(_view);
        setupRV();

        return _view;
    }

    private void init(View view) {

        loginDBAdapter = new LoginDBAdapter(getContext());
        loginDBAdapter = loginDBAdapter.open();

        session = new SessionManager(getContext());
        HashMap<String, String> user = session.getUserDetails();

        userName = user.get(SessionManager.KEY_USERNAME);

        rv = (RecyclerView) view.findViewById(R.id.recycler_view);
//        setupRV();

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
}
