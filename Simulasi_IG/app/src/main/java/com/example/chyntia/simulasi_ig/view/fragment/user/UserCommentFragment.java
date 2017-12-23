package com.example.chyntia.simulasi_ig.view.fragment.user;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.design.widget.BottomNavigationView;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.view.inputmethod.EditorInfo;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.activity.MainActivity;
import com.example.chyntia.simulasi_ig.view.adapter.FollowingRVAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.HomeRVAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.LoginDBAdapter;
import com.example.chyntia.simulasi_ig.view.adapter.UserCommentRVAdapter;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.model.Comment;
import com.example.chyntia.simulasi_ig.view.network.response.CResponse;
import com.example.chyntia.simulasi_ig.view.network.response.CommentResponse;
import com.example.chyntia.simulasi_ig.view.network.response.UserProfileResponse;
import com.example.chyntia.simulasi_ig.view.utilities.DatetimeUtils;

import java.text.ParseException;
import java.util.Date;
import java.util.HashMap;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static com.example.chyntia.simulasi_ig.view.utilities.DatetimeUtils.dateToString;

/**
 * Created by Chyntia on 5/28/2017.
 */

public class UserCommentFragment extends Fragment {
    private BottomNavigationView bottomNavigationView;
    TextView text;
    ImageView ic_left,ic_right,ic_send;
    EditText comment;
    RecyclerView rv;
//    LoginDBAdapter loginDBAdapter;
    SessionManager session;
    String userName;
    MyAsyncTask myAsyncTask;
    UserCommentRVAdapter adapter;
    int posting_id;

    public UserCommentFragment() {
        // Required empty public constructor
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        posting_id = getArguments().getInt("POSITION");
    }

    public static UserCommentFragment newInstance() {
        return new UserCommentFragment();
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View _view = inflater.inflate(R.layout.fragment_user_comment, container, false);

        init(_view);
        event();
        setupRV();
        showInputMethod();

        return _view;
    }

    private void init(View view) {

        session = new SessionManager(getContext());
        HashMap<String, String> user = session.getUserDetails();

        userName = user.get(SessionManager.KEY_USERNAME);

        text = (TextView) view.findViewById(R.id.toolbar_title);
        text.setText("Comments");

        ic_left = (ImageView) view.findViewById(R.id.icon_left);
        ic_left.setImageResource(R.drawable.ic_arrow_back_black_24dp);

        ic_right = (ImageView) view.findViewById(R.id.icon_right);
        ic_right.setImageResource(0);

        comment = (EditText) view.findViewById(R.id.commenttext);
        comment.requestFocus();

        rv = (RecyclerView) view.findViewById(R.id.comment_rv);

        ic_send = (ImageView) view.findViewById(R.id.send);

        ((MainActivity) view.getContext()).hide_bottom_nav_bar();
    }

    private void event() {
        ic_left.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                hideKeyboard(getContext());
                ((MainActivity) getActivity()).show_bottom_nav_bar();
                ((MainActivity) getActivity()).changefragment(new HomeFragment(),"Home");
            }
        });

        ic_send.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String comment_text = comment.getText().toString();

                final String token = session.getUserDetails().get(SessionManager.KEY_USERNAME);
                ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
                Call<CResponse> call = apiRoute.AddComment(token, posting_id, comment.getText().toString());
                call.enqueue(new Callback<CResponse>() {
                    @Override
                    public void onResponse(Call<CResponse> call, Response<CResponse> response) {
                        CResponse data = response.body();

                        if(data.isStatus()){
                            ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
                            Call<UserProfileResponse> call2 = apiRoute.GetUserProfile(token);
                            call2.enqueue(new Callback<UserProfileResponse>() {
                                @Override
                                public void onResponse(Call<UserProfileResponse> call, Response<UserProfileResponse> response) {
                                    UserProfileResponse data2 = response.body();

                                    if(data2.isStatus() != false) {
                                        try {
                                            Comment com = new Comment(posting_id, data2.getData().getId(), comment_text.toString(), DatetimeUtils.dateToString(new Date()), data2.getData().getUserName(), data2.getData().getImagePath());
                                            adapter.add(com);

                                        } catch (ParseException e) {
                                            e.printStackTrace();
                                        }
                                    }
                                }

                                @Override
                                public void onFailure(Call<UserProfileResponse> call, Throwable t) {

                                }
                            });
                        }
                    }

                    @Override
                    public void onFailure(Call<CResponse> call, Throwable t) {

                    }
                });
                comment.setText("");
                hideKeyboard(getContext());

              /*  loginDBAdapter.insert_Comments(posting_id,loginDBAdapter.getID(userName),loginDBAdapter.getUserProfPic(loginDBAdapter.getID(userName)),comment.getText().toString(),String.valueOf(System.currentTimeMillis()));
                loginDBAdapter.insert_Notif(loginDBAdapter.getUserProfPic(loginDBAdapter.getID(userName)),loginDBAdapter.getID(userName),"Comment",String.valueOf(System.currentTimeMillis()),posting_id,0);
                hideKeyboard(getContext());
                myAsyncTask = new MyAsyncTask();
                myAsyncTask.execute();*/
            }
        });
    }

    public void showInputMethod() {
        InputMethodManager imm = (InputMethodManager) getActivity().getSystemService(Context.INPUT_METHOD_SERVICE);
        imm.toggleSoftInput(InputMethodManager.SHOW_FORCED, InputMethodManager.HIDE_IMPLICIT_ONLY);
        getActivity().getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_ADJUST_RESIZE);
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

    private void setupRV(){
        String token = session.getUserDetails().get(SessionManager.KEY_USERNAME);

        ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
        Call<CommentResponse> call = apiRoute.getComment(token, posting_id);
        call.enqueue(new Callback<CommentResponse>() {
            @Override
            public void onResponse(Call<CommentResponse> call, Response<CommentResponse> response) {
                CommentResponse data = response.body();

                if(data.isStatus()){
                    adapter = new UserCommentRVAdapter(data.getData(), getActivity().getApplication());
                    rv.setAdapter(adapter);
                    rv.setLayoutManager(new LinearLayoutManager(getActivity().getApplicationContext()));
                }
            }

            @Override
            public void onFailure(Call<CommentResponse> call, Throwable t) {
                Log.e("ERR", String.valueOf(t.getMessage()));            }
        });
    }

    class MyAsyncTask extends AsyncTask<Void, Integer, Void> {

        boolean running;
        ProgressDialog progressDialog;

        @Override
        protected Void doInBackground(Void... params) {
            int i = 2;
            while(running){
                try {
                    Thread.sleep(1000);
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }

                if(i-- == 0){
                    running = false;
                }

                publishProgress(i);

            }
            return null;
        }

        @Override
        protected void onProgressUpdate(Integer... values) {
            super.onProgressUpdate(values);
            progressDialog.setMessage("Loading...");
        }

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            running = true;

            progressDialog = ProgressDialog.show(getActivity(),"",
                    "Loading...");

            progressDialog.setCanceledOnTouchOutside(true);
            progressDialog.setOnCancelListener(new DialogInterface.OnCancelListener() {
                @Override
                public void onCancel(DialogInterface dialog) {
                    running = false;
                }
            });
        }

        @Override
        protected void onPostExecute(Void aVoid) {
            super.onPostExecute(aVoid);

            //getProfilePic();
            comment.setText("");
            setupRV();

            progressDialog.dismiss();

        }

    }
}
