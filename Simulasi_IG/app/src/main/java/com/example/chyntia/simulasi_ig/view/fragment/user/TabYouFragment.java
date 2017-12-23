package com.example.chyntia.simulasi_ig.view.fragment.user;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.DecelerateInterpolator;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.adapter.HomeRVAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.LoginDBAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.NotifTabYouRVAdapter;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.response.NotifResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserProfileResponse;
import com.nshmura.snappysmoothscroller.SnapType;
import com.nshmura.snappysmoothscroller.SnappyLinearLayoutManager;

import java.util.HashMap;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Chyntia on 5/20/2017.
 */

public class TabYouFragment extends Fragment {
    public static final String ARG_PAGE = "ARG_PAGE";
    RecyclerView rv;
    Toolbar toolbar;
//    LoginDBAdapter loginDBAdapter;
    SessionManager session;
    String userName;

    public TabYouFragment() {
        // Required empty public constructor
    }

    public static TabYouFragment newInstance(int page) {
        Bundle args = new Bundle();
        args.putInt(ARG_PAGE, page);
        TabYouFragment fragment = new TabYouFragment();
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    // Inflate the view for the fragment based on layout XML
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View _view = inflater.inflate(R.layout.fragment_tab_you, container, false);

        init(_view);
        setupRV();

        return _view;
    }

    private void init(View v) {

        session = new SessionManager(getContext());
        HashMap<String, String> user = session.getUserDetails();

        userName = user.get(SessionManager.KEY_USERNAME);

        rv = (RecyclerView) v.findViewById(R.id.recycler_view_tab_you);

    }

    private void setupRV(){
        String token = session.getUserDetails().get(SessionManager.KEY_USERNAME);
        ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
        Call<NotifResponse> call = apiRoute.getNotif(token);
        call.enqueue(new Callback<NotifResponse>() {
            @Override
            public void onResponse(Call<NotifResponse> call, Response<NotifResponse> response) {
                NotifResponse data = response.body();

                if(data.isStatus()){

                    NotifTabYouRVAdapter adapter = new NotifTabYouRVAdapter(data.getData(), getActivity().getApplication());
                    rv.setAdapter(adapter);
                    rv.setLayoutManager(new LinearLayoutManager(getActivity().getApplicationContext()));
                }
                else{
                    changefragment(new TabYouViewFragment(), "TabYouView");
                    rv.setVisibility(View.GONE);
                }
            }

            @Override
            public void onFailure(Call<NotifResponse> call, Throwable t) {
                changefragment(new TabYouViewFragment(), "TabYouView");
                rv.setVisibility(View.GONE);
            }
        });
    }

    public void changefragment(Fragment fragment, String tag) {
        getActivity().getSupportFragmentManager().beginTransaction().replace(R.id.tab_you_content, fragment, tag).commit();
    }
}
