package com.example.chyntia.simulasi_ig.view.adapter;

import android.content.Context;
import android.graphics.Color;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.model.entity.Data_Follow;
import com.example.chyntia.simulasi_ig.view.model.entity.User;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.model.UserProfileSearch;
import com.example.chyntia.simulasi_ig.view.network.response.CResponse;
import com.squareup.picasso.Picasso;

import java.io.File;
import java.util.HashMap;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static com.example.chyntia.simulasi_ig.R.drawable.btn_follow;

/**
 * Created by Chyntia on 6/10/2017.
 */

public class FriendRecommendationRVAdapter extends RecyclerView.Adapter<RecyclerView.ViewHolder> {
    List<UserProfileSearch> user;
    Context context;
    private boolean isButtonClicked = false;
//    LoginDBAdapter loginDBAdapter;
    SessionManager session;
    String userName;
    String token;


    public FriendRecommendationRVAdapter(List<UserProfileSearch> user, Context context) {
        this.user = user;
        this.context = context;
        session = new SessionManager(context);
        token = session.getUserDetails().get(SessionManager.KEY_USERNAME);
    }

    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        //Inflate the layout, initialize the View Holder
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.custom_row_user, parent, false);


        HashMap<String, String> user = session.getUserDetails();

        userName = user.get(SessionManager.KEY_USERNAME);

        return new FriendRecommendationRVAdapter.ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(RecyclerView.ViewHolder holder, int position) {
        final FriendRecommendationRVAdapter.ViewHolder _holder = (FriendRecommendationRVAdapter.ViewHolder) holder;
        final UserProfileSearch _user = this.user.get(position);
        //Use the provided View Holder on the onCreateViewHolder method to populate the current row on the RecyclerView
        _holder.nama.setText(_user.getUserName());

        if(_user.getImagePath() != ""){
            Picasso
                    .with(context)
                    .load(ApiRetrofit.URL + _user.getImagePath())
                  /*  .resize(dpToPx(20), dpToPx(20))
                    .centerCrop()*/
                    .error(R.drawable.ic_account_circle_black_24dp)
                    .into(_holder.pp);
        }
        else
            _holder.pp.setImageResource(R.drawable.ic_account_circle_black_24dp);

        _holder.btn.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                follow_states(v,_holder, _user);
            }
        });
        //animate(holder);
    }

    private int dpToPx(int dp)
    {
        float density = context.getResources().getDisplayMetrics().density;
        return Math.round((float)dp * density);
    }

    public void follow_states(View v, FriendRecommendationRVAdapter.ViewHolder _holder, UserProfileSearch _user){
        if (v.getId() == R.id.btn) {
            isButtonClicked = !isButtonClicked; // toggle the boolean flag
            /** FOLLOW */
            if(isButtonClicked){
                ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
                Call<CResponse> call = apiRoute.follow(token, _user.getUserName());
                call.enqueue(new Callback<CResponse>() {
                    @Override
                    public void onResponse(Call<CResponse> call, Response<CResponse> response) {
                        CResponse data = response.body();

                    }

                    @Override
                    public void onFailure(Call<CResponse> call, Throwable t) {

                    }
                });

                _holder.btn.setText("Following");
                _holder.btn.setTextColor(Color.BLACK);
                v.setBackgroundResource(R.drawable.btn_following);
            }

            else{
                ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
                Call<CResponse> call = apiRoute.unFollow(token, _user.getUserName());
                call.enqueue(new Callback<CResponse>() {
                    @Override
                    public void onResponse(Call<CResponse> call, Response<CResponse> response) {
                        CResponse data = response.body();

                    }

                    @Override
                    public void onFailure(Call<CResponse> call, Throwable t) {

                    }
                });

                _holder.btn.setText("Follow");
                _holder.btn.setTextColor(Color.WHITE);
                v.setBackgroundResource(btn_follow);
            }
          /*  if(isButtonClicked)
            {
                //PrettyTime p = new PrettyTime();
                loginDBAdapter.insert_Follow(loginDBAdapter.getID(userName),loginDBAdapter.getID(_holder.nama.getText().toString()),String.valueOf(System.currentTimeMillis()));
                loginDBAdapter.insert_Notif(loginDBAdapter.getUserProfPic(loginDBAdapter.getID(userName)),loginDBAdapter.getID(userName),"Follow",String.valueOf(System.currentTimeMillis()),0,loginDBAdapter.getID(_holder.nama.getText().toString()));
                _holder.btn.setTextColor(isButtonClicked ? Color.BLACK : Color.WHITE);
                _holder.btn.setText(isButtonClicked ? "Following" : "Follow");
                v.setBackgroundResource(isButtonClicked ? R.drawable.btn_following : btn_follow);
            }*/
        }
    }

    @Override
    public int getItemCount() {
        //returns the number of elements the RecyclerView will display
        return user.size();
    }

    @Override
    public void onAttachedToRecyclerView(RecyclerView recyclerView) {
        super.onAttachedToRecyclerView(recyclerView);
    }

    // Insert a new item to the RecyclerView on a predefined position
    public void insert(int position, UserProfileSearch dataFollow) {
        user.add(position, dataFollow);
        notifyItemInserted(position);
    }

    // Remove a RecyclerView item containing a specified Data_Follow object
    public void remove(Data_Follow dataFollow) {
        int position = user.indexOf(dataFollow);
        user.remove(position);
        notifyItemRemoved(position);
    }

    public class ViewHolder extends RecyclerView.ViewHolder {

        TextView nama;
        ImageView pp;
        Button btn;

        public ViewHolder(View itemView) {
            super(itemView);
            nama = (TextView) itemView.findViewById(R.id.nama);
            pp = (ImageView) itemView.findViewById(R.id.pp_follow);
            btn = (Button) itemView.findViewById(R.id.btn);
        }
    }
}
