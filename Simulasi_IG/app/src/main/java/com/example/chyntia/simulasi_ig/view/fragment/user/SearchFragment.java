package com.example.chyntia.simulasi_ig.view.fragment.user;

import android.app.Activity;
import android.content.Context;
import android.graphics.Color;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.design.widget.BottomNavigationView;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.Editable;
import android.text.InputType;
import android.text.TextWatcher;
import android.text.method.ArrowKeyMovementMethod;
import android.util.Log;
import android.view.Gravity;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.view.inputmethod.EditorInfo;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.activity.MainActivity;
import com.example.chyntia.simulasi_ig.view.adapter.FollowersRVAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.LoginDBAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.SearchRVAdapter;
import com.example.chyntia.simulasi_ig.view.model.entity.User;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.response.SearchResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserResponse;

import java.util.ArrayList;
import java.util.HashMap;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Chyntia on 5/23/2017.
 */

public class SearchFragment extends Fragment {
    private BottomNavigationView bottomNavigationView;
    TextView text, tv_userNotFound;
    ImageView ic_left,ic_right;
    EditText edit_text;
    LoginDBAdapter loginDBAdapter;
    SessionManager session;
    String userName;
    RecyclerView rv;

    public SearchFragment() {
        // Required empty public constructor
    }

    public static SearchFragment newInstance() {
        return new SearchFragment();
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View _view = inflater.inflate(R.layout.fragment_search, container, false);

        init(_view);
        event();
        showInputMethod();

        return _view;
    }

    private void init(View view) {

        loginDBAdapter = new LoginDBAdapter(getContext());
        loginDBAdapter = loginDBAdapter.open();

        session = new SessionManager(getContext());
        HashMap<String, String> user = session.getUserDetails();

        userName = user.get(SessionManager.KEY_USERNAME);

        text = (TextView) view.findViewById(R.id.toolbar_title);
        text.setVisibility(View.GONE);
        edit_text = (EditText) view.findViewById(R.id.editText);
        edit_text.setVisibility(View.VISIBLE);
        edit_text.requestFocus();

        ic_right = (ImageView) view.findViewById(R.id.icon_right);
        ic_right.setImageResource(0);

        ic_left = (ImageView) view.findViewById(R.id.icon_left);
        ic_left.setImageResource(R.drawable.ic_arrow_back_black_24dp);

        rv = (RecyclerView) view.findViewById(R.id.recycler_view_search);

        tv_userNotFound = (TextView) view.findViewById(R.id.tv_userNotFound);
    }

    private void event() {
        ic_left.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                hideKeyboard(getContext());
                ((MainActivity) getActivity()).onBackPressed();
            }
        });

        ic_right.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                edit_text.setText("");
            }
        });

        edit_text.addTextChangedListener(new TextWatcher() {

            @Override
            public void onTextChanged(CharSequence arg0, int arg1, int arg2,
                                      int arg3) {
                //
                // setupRV(arg0.toString());
            }

            @Override
            public void beforeTextChanged(CharSequence arg0, int arg1,
                                          int arg2, int arg3) {
            }

            @Override
            public void afterTextChanged(Editable name) {
                if(edit_text.getText().toString().length()>0){
                    ic_right.setImageResource(R.drawable.ic_close_black_24dp);
                }else{
                    ic_right.setVisibility(View.INVISIBLE);
                }
            }

        });

        edit_text.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
                if (actionId == EditorInfo.IME_ACTION_SEARCH) {
                    String token = session.getUserDetails().get(SessionManager.KEY_USERNAME);
                    ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
                    Call<SearchResponse> call = apiRoute.searchUser(token, edit_text.getText().toString());
                    call.enqueue(new Callback<SearchResponse>() {
                        @Override
                        public void onResponse(Call<SearchResponse> call, Response<SearchResponse> response) {
                            edit_text.clearFocus();
                            hideKeyboard(getContext());

                            SearchResponse data = response.body();
                            if(data.isStatus()){
                                ArrayList<User> _users = data.getData();
                                SearchRVAdapter adapter = new SearchRVAdapter(_users, getActivity().getApplication());
                                rv.setAdapter(adapter);
                                rv.setLayoutManager(new LinearLayoutManager(getActivity().getApplicationContext()));
                            }
                            else{
                                rv.setVisibility(View.GONE);
                                tv_userNotFound.setVisibility(View.VISIBLE);
                            }
                            Log.d("Search Error", data.getMessage());
                        }

                        @Override
                        public void onFailure(Call<SearchResponse> call, Throwable t) {
                            Log.e("ERR", String.valueOf(t.getMessage()));                        }
                    });

                    return true;
                }
                return false;
            }
        });
    }

    public void showInputMethod() {
        InputMethodManager imm = (InputMethodManager) getActivity().getSystemService(Context.INPUT_METHOD_SERVICE);
        imm.toggleSoftInput(InputMethodManager.SHOW_FORCED,InputMethodManager.HIDE_IMPLICIT_ONLY);
        getActivity().getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_ADJUST_PAN);
    }

    public static void hideKeyboard(Context ctx) {
        InputMethodManager inputManager = (InputMethodManager) ctx
                .getSystemService(Context.INPUT_METHOD_SERVICE);

        // check if no view has focus:
        View v = ((Activity) ctx).getCurrentFocus();
        if (v == null)
            return;

        inputManager.hideSoftInputFromWindow(v.getWindowToken(), 0);
    }
}
