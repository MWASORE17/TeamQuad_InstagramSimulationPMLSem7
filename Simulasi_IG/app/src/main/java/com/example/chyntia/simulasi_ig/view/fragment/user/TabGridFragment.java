package com.example.chyntia.simulasi_ig.view.fragment.user;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.adapter.LoginDBAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.ProfileVPAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.TabGridRVAdapter;
import com.example.chyntia.simulasi_ig.view.enumeration.TransEnum;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.response.PostsResponse;

import java.util.HashMap;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Chyntia on 5/26/2017.
 */

public class TabGridFragment extends Fragment{
    public static final String ARG_PAGE = "ARG_PAGE";
    RecyclerView rv;
    SessionManager session;
//    LoginDBAdapter loginDBAdapter;
    String userName;
    String token;
    TransEnum transEnum;

    public TabGridFragment() {
        // Required empty public constructor
    }

    public static TabGridFragment newInstance(String token, TransEnum transEnum) {
        TabGridFragment utgf = new TabGridFragment();
        Bundle args = new Bundle();
        args.putString("USERNAME", token);
        args.putSerializable("ENUM", transEnum);
        utgf.setArguments(args);
        return utgf;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        token = getArguments().getString("USERNAME");
        transEnum = (TransEnum) getArguments().getSerializable("ENUM");
        session = new SessionManager(getContext());
        HashMap<String, String> user = session.getUserDetails();
        // name
        userName = user.get(SessionManager.KEY_USERNAME);
    }

    // Inflate the view for the fragment based on layout XML
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View _view = inflater.inflate(R.layout.fragment_tab_grid, container, false);

        init(_view);

        return _view;
    }

    private void init(View view) {
        rv = (RecyclerView) view.findViewById(R.id.rv_grid_profile);
        setupRV();
    }

    private void setupRV(){

        /** POST */
        ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
        Call<PostsResponse> call = apiRoute.getAccountPosts(token);
        call.enqueue(new Callback<PostsResponse>() {
            @Override
            public void onResponse(Call<PostsResponse> call, Response<PostsResponse> response) {
                PostsResponse data = response.body();
                if(data.isStatus()){
                    TabGridRVAdapter adapter = new TabGridRVAdapter(data.getFeeds(), getActivity().getApplication(), transEnum);
                    rv.setAdapter(adapter);
                    rv.setLayoutManager(new GridLayoutManager(getContext(),3));
                }
                else{
//                    Log.e("user post", data.getMessage());
                }
            }

            @Override
            public void onFailure(Call<PostsResponse> call, Throwable t) {
//                Log.e("ERR", String.valueOf(t.getMessage()));
            }
        });
    }
}