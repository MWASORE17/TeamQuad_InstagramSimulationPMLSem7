package com.example.chyntia.simulasi_ig.view.fragment.user;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.DecelerateInterpolator;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.adapter.HomeRVAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.LoginDBAdapter;
import com.example.chyntia.simulasi_ig.view.model.entity.Data_TL;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.response.PostsResponse;
import com.nshmura.snappysmoothscroller.SnapType;
import com.nshmura.snappysmoothscroller.SnappyLinearLayoutManager;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static android.R.attr.data;

/**
 * Created by Chyntia on 5/26/2017.
 */

public class TabDetailFragment extends Fragment {
    public static final String ARG_PAGE = "ARG_PAGE";
    TextView text;
    ImageView ic_left,ic_right, ic_friend_recommendation;
    RecyclerView rv;
    LoginDBAdapter loginDBAdapter;
    SessionManager session;
    String userName;
    String token;

    public TabDetailFragment() {
        // Required empty public constructor
    }

    public static TabDetailFragment newInstance(String token) {
        Bundle args = new Bundle();
        args.putString(ARG_PAGE, token);
        TabDetailFragment fragment = new TabDetailFragment();
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        token = getArguments().getString(ARG_PAGE);
    }

    // Inflate the view for the fragment based on layout XML
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View _view = inflater.inflate(R.layout.fragment_tab_detail, container, false);

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

        rv = (RecyclerView) view.findViewById(R.id.recycler_view_detail);

    }

    private void setupRV(){
        ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
        Call<PostsResponse> call = apiRoute.getAccountPosts(token);
        call.enqueue(new Callback<PostsResponse>() {
            @Override
            public void onResponse(Call<PostsResponse> call, Response<PostsResponse> response) {
                PostsResponse data = response.body();

                if(data.isStatus()){
                    if(data.getFeeds().size() > 0){
                        HomeRVAdapter adapter = new HomeRVAdapter(data.getFeeds(), getActivity().getApplication());
                        rv.setAdapter(adapter);
                        SnappyLinearLayoutManager layoutManager = new SnappyLinearLayoutManager(getActivity().getApplicationContext());
                        layoutManager.setSnapType(SnapType.CENTER);
                        layoutManager.setSnapInterpolator(new DecelerateInterpolator());
                        rv.setLayoutManager(layoutManager);
                        rv.smoothScrollToPosition(0);
                    }
                    else{
                        rv.setVisibility(View.GONE);
                    }
                }
                else{
                    rv.setVisibility(View.GONE);
                    Log.e("ERR", data.getMessage());
                }
            }

            @Override
            public void onFailure(Call<PostsResponse> call, Throwable t) {
                Log.e("ERR", String.valueOf(t.getMessage()));
            }
        });
    }
}
