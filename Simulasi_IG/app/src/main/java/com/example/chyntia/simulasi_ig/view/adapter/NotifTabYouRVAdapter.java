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
import com.example.chyntia.simulasi_ig.view.model.entity.Data_Notif;
import com.example.chyntia.simulasi_ig.view.model.entity.User;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.model.Notif;
import com.example.chyntia.simulasi_ig.view.network.response.CResponse;
import com.example.chyntia.simulasi_ig.view.utilities.DatetimeUtils;
import com.squareup.picasso.Picasso;

import java.io.File;
import java.text.ParseException;
import java.util.HashMap;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static com.example.chyntia.simulasi_ig.R.drawable.btn_follow;

/**
 * Created by Chyntia on 6/18/2017.
 */

public class NotifTabYouRVAdapter extends RecyclerView.Adapter<RecyclerView.ViewHolder> {
    List<Notif> user;
    Context context;
    private boolean isButtonClicked = false;
//    LoginDBAdapter loginDBAdapter;
    SessionManager session;
    String userName;
    private static final int SECOND_MILLIS = 1000;
    private static final int MINUTE_MILLIS = 60 * SECOND_MILLIS;
    private static final int HOUR_MILLIS = 60 * MINUTE_MILLIS;
    private static final int DAY_MILLIS = 24 * HOUR_MILLIS;
    String token;

    public NotifTabYouRVAdapter(List<Notif> user, Context context) {
        this.user = user;
        this.context = context;
        session = new SessionManager(context);
        this.token = session.getUserDetails().get(SessionManager.KEY_USERNAME);
    }

    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        //Inflate the layout, initialize the View Holder
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.custom_notification_tab_you, parent, false);


        HashMap<String, String> user = session.getUserDetails();

        userName = user.get(SessionManager.KEY_USERNAME);

        return new NotifTabYouRVAdapter.ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(RecyclerView.ViewHolder holder, int position) {
        final NotifTabYouRVAdapter.ViewHolder _holder = (NotifTabYouRVAdapter.ViewHolder) holder;
        final Notif _user = this.user.get(position);
        //Use the provided View Holder on the onCreateViewHolder method to populate the current row on the RecyclerView
        _holder.nama.setVisibility(View.GONE);

       /* if(_user.user_id == loginDBAdapter.getID(userName)) {
            _holder.content.setVisibility(View.GONE);
            _holder.created_at.setVisibility(View.GONE);
            _holder.pp.setVisibility(View.GONE);
        }
        else {*/
            if (_user.getType().equals("follow")) {
                _holder.content.setText(_user.getUserName() + " started following\nyou");
                _holder.btn.setVisibility(View.VISIBLE);

                if (_user.getIsFollowing() == 1) {
                    _holder.btn.setText("Following");
                    _holder.btn.setTextColor(Color.BLACK);
                    _holder.btn.setBackgroundResource(R.drawable.btn_following);
                } else {
                    _holder.btn.setText("Follow");
                    _holder.btn.setTextColor(Color.WHITE);
                    _holder.btn.setBackgroundResource(btn_follow);
                }

                _holder.btn.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {

                        if (_user.getIsFollowing() == 0)
                            isButtonClicked = !isButtonClicked;

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
                    }
                });
            } else if (_user.getType().equals("like")) {
                _holder.content.setText(_user.getUserName() + " liked your post");
                _holder.photo.setVisibility(View.VISIBLE);
                Picasso
                        .with(context)
                        .load(ApiRetrofit.URL + _user.getImagePath())
                        .resize(dpToPx(40), dpToPx(40))
                        .centerCrop()
                        .error(R.drawable.ic_account_circle_black_24dp)
                        .into(_holder.photo);
            } else if (_user.getType().equals("comment")) {
                _holder.content.setText(_user.getUserName() + " commented on your post");
                _holder.photo.setVisibility(View.VISIBLE);
                Picasso
                        .with(context)
                        .load(ApiRetrofit.URL + _user.getImagePath())
                        .resize(dpToPx(40), dpToPx(40))
                        .centerCrop()
                        .error(R.drawable.ic_account_circle_black_24dp)
                        .into(_holder.photo);
            }


            if (_user.getImagePath() != "") {
                Picasso
                        .with(context)
                        .load(ApiRetrofit.URL + _user.getUserImage())
                        .resize(dpToPx(20), dpToPx(20))
                        .centerCrop()
                        .error(R.drawable.ic_account_circle_black_24dp)
                        .into(_holder.pp);
            } else
                _holder.pp.setImageResource(R.drawable.ic_account_circle_black_24dp);
        try {
            _holder.created_at.setText(getTimeAgo(DatetimeUtils.stringToDate(_user.getCreated_on()).getTime()));
        } catch (ParseException e) {
            e.printStackTrace();
        }
        /*}*/
    }

    private int dpToPx(int dp)
    {
        float density = context.getResources().getDisplayMetrics().density;
        return Math.round((float)dp * density);
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
    public void insert(int position, Notif data) {
        user.add(position, data);
        notifyItemInserted(position);
    }

    // Remove a RecyclerView item containing a specified Data_Follow object
    public void remove(Data_Notif data) {
        int position = user.indexOf(data);
        user.remove(position);
        notifyItemRemoved(position);
    }

    public class ViewHolder extends RecyclerView.ViewHolder {

        TextView nama, content, created_at;
        ImageView pp, photo;
        Button btn;

        public ViewHolder(View itemView) {
            super(itemView);
            nama = (TextView) itemView.findViewById(R.id.username_notif);
            pp = (ImageView) itemView.findViewById(R.id.pp_notif);
            btn = (Button) itemView.findViewById(R.id.btn_notif);
            content = (TextView) itemView.findViewById(R.id.content_notif);
            created_at = (TextView) itemView.findViewById(R.id.time_notif);
            photo = (ImageView) itemView.findViewById(R.id.photo_notif);
        }
    }

    public static String getTimeAgo(long time) {
        if (time < 1000000000000L) {
            // if timestamp given in seconds, convert to millis
            time *= 1000;
        }

        long now = System.currentTimeMillis();
        if (time > now || time <= 0) {
            return null;
        }

        // TODO: localize
        final long diff = now - time;
        if (diff < MINUTE_MILLIS) {
            return "just now";
        } else if (diff < 2 * MINUTE_MILLIS) {
            return "a minute ago";
        } else if (diff < 50 * MINUTE_MILLIS) {
            return diff / MINUTE_MILLIS + " minutes ago";
        } else if (diff < 90 * MINUTE_MILLIS) {
            return "an hour ago";
        } else if (diff < 24 * HOUR_MILLIS) {
            return diff / HOUR_MILLIS + " hours ago";
        } else if (diff < 48 * HOUR_MILLIS) {
            return "yesterday";
        } else {
            return diff / DAY_MILLIS + " days ago";
        }
    }
}

