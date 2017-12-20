package com.example.chyntia.simulasi_ig.view.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.model.entity.Data_TL;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.ApiRoute;
import com.example.chyntia.simulasi_ig.view.network.response.CResponse;
import com.example.chyntia.simulasi_ig.view.network.response.LoginResponse;
import com.example.chyntia.simulasi_ig.view.network.response.PostResponse;
import com.example.chyntia.simulasi_ig.view.utilities.DatetimeUtils;
import com.like.LikeButton;
import com.like.OnLikeListener;
import com.squareup.picasso.Picasso;

import java.text.ParseException;
import java.util.ArrayList;
import java.util.HashMap;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Chyntia on 5/24/2017.
 */

public class HomeRVAdapter extends RecyclerView.Adapter<RecyclerView.ViewHolder> {
    ArrayList<PostResponse> user;
    Context context;
    private boolean isButtonClicked = false;

    LoginDBAdapter loginDBAdapter;
    String userName;
    SessionManager session;
    boolean isLike = false;
    boolean curr_state;
    private static final int SECOND_MILLIS = 1000;
    private static final int MINUTE_MILLIS = 60 * SECOND_MILLIS;
    private static final int HOUR_MILLIS = 60 * MINUTE_MILLIS;
    private static final int DAY_MILLIS = 24 * HOUR_MILLIS;

    public HomeRVAdapter(ArrayList<PostResponse> user, Context context) {
        session = new SessionManager(context);

        this.user = user;
        this.context = context;
    }

    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        //Inflate the layout, initialize the View Holder
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.custom_row_timeline, parent, false);

        /*loginDBAdapter = new LoginDBAdapter(context);
        loginDBAdapter = loginDBAdapter.open();*/

        return new HomeRVAdapter.ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(final RecyclerView.ViewHolder holder, final int position) {
        final String token = session.getUserDetails().get(SessionManager.KEY_USERNAME);
        final HomeRVAdapter.ViewHolder _holder = (HomeRVAdapter.ViewHolder) holder;
        final PostResponse _post = this.user.get(position);
        //Use the provided View Holder on the onCreateViewHolder method to populate the current row on the RecyclerView
        _holder.nama.setText(_post.getUserName());

        if (_post.getUserName().equals("airasia"))
            _holder.title_advertisement.setVisibility(View.VISIBLE);

        if (_post.getImagePath() == "" || _post.getImagePath() == null) {
            Picasso
                    .with(context)
                    .load(ApiRetrofit.URL + _post.getImagePath())
                    .resize(dpToPx(20), dpToPx(20))
                    .centerCrop()
                    .error(R.drawable.ic_account_circle_black_24dp)
                    .into(_holder.pp);
        } else
            _holder.pp.setImageResource(R.drawable.ic_account_circle_black_24dp);

        _holder.comment.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
               /* int position = loginDBAdapter.getAllPosting(loginDBAdapter.getID(userName)).size()-_holder.getAdapterPosition();
                UserCommentFragment ucf = new UserCommentFragment();
                final Bundle args = new Bundle();
                args.putInt("POSITION", position);
                ucf.setArguments(args);
                ((MainActivity) v.getContext()).changefragment(ucf, "UserComment");*/
            }
        });

     /*   if(loginDBAdapter.check_TBComments().equals("NOT EMPTY")) {
            _holder.view_comment.setVisibility(View.VISIBLE);
            if(loginDBAdapter.getAllComments(loginDBAdapter.getAllPosting(loginDBAdapter.getID(userName)).size()-_holder.getAdapterPosition()).size() == 0){
                _holder.view_comment.setVisibility(View.GONE);
            }
            else if(loginDBAdapter.getAllComments(loginDBAdapter.getAllPosting(loginDBAdapter.getID(userName)).size()-_holder.getAdapterPosition()).size() == 1) {
                _holder.view_comment.setText("View 1 comment");
                _holder.view_comment.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        int position = loginDBAdapter.getAllPosting(loginDBAdapter.getID(userName)).size() - _holder.getAdapterPosition();
                        UserCommentFragment ucf = new UserCommentFragment();
                        final Bundle args = new Bundle();
                        args.putInt("POSITION", position);
                        ucf.setArguments(args);
                        ((MainActivity) v.getContext()).changefragment(ucf, "UserComment");
                    }
                });
            }

            else{
                _holder.view_comment.setText("View all "+String.valueOf(loginDBAdapter.getAllComments(loginDBAdapter.getAllPosting(loginDBAdapter.getID(userName)).size()-_holder.getAdapterPosition()).size())+" comments");
                _holder.view_comment.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        int position = loginDBAdapter.getAllPosting(loginDBAdapter.getID(userName)).size() - _holder.getAdapterPosition();
                        UserCommentFragment ucf = new UserCommentFragment();
                        final Bundle args = new Bundle();
                        args.putInt("POSITION", position);
                        ucf.setArguments(args);
                        ((MainActivity) v.getContext()).changefragment(ucf, "UserComment");
                    }
                });
            }
        }*/

        /** User Liked Post*/
        if(user.get(position).getIsUnlike() == 0) {
            _holder.like.setLiked(true);
            _holder.like.setLikeDrawableRes(R.drawable.ic_heart_red);
        }
        else {
            _holder.like.setLiked(false);
            _holder.like.setUnlikeDrawableRes(R.drawable.ic_heart_outline_grey);
        }

        /** Count Like Post*/
        if (user.get(position).getTotalLikes() > 0) {
            _holder.count_likes.setVisibility(View.VISIBLE);

            if (user.get(position).getTotalLikes() == 1)
                _holder.count_likes.setText(user.get(position).getTotalLikes() + " like");

            else
                _holder.count_likes.setText(user.get(position).getTotalLikes() + " likes");
        } else {
            _holder.count_likes.setVisibility(View.GONE);
        }

        /** Like or UnLike Post*/
        _holder.like.setOnLikeListener(new OnLikeListener() {
            @Override
            public void liked(LikeButton likeButton) {
                _holder.count_likes.setVisibility(View.VISIBLE);

                /** Insert Like*/
                ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
                Call<CResponse> call = apiRoute.postLike(token, user.get(position).getPostID());
                call.enqueue(new Callback<CResponse>() {
                    @Override
                    public void onResponse(Call<CResponse> call, Response<CResponse> response) {
                        CResponse data = response.body();

                        if(data.isStatus()){
                            Log.i("Success IG", data.getMessage());
                        }
                        else{
                            Log.e("Failed IG", data.getMessage());
                        }
                    }

                    @Override
                    public void onFailure(Call<CResponse> call, Throwable t) {
                        Log.d("Failed IG", t.getMessage());
                    }
                });

                /** Insert Notif*/

                user.get(position).setTotalLikes(user.get(position).getTotalLikes()+ 1);
                int totalLikes = user.get(position).getTotalLikes();
                if (totalLikes == 0)
                    _holder.count_likes.setVisibility(View.GONE);

                else if (totalLikes == 1)
                    _holder.count_likes.setText(1 + " like");

                else
                    _holder.count_likes.setText(totalLikes + " likes");

            }

            @Override
            public void unLiked(LikeButton likeButton) {
                _holder.count_likes.setVisibility(View.VISIBLE);

                /** UnLike*/
                ApiRoute apiRoute = ApiRetrofit.getApiClient().create(ApiRoute.class);
                Call<CResponse> call = apiRoute.postUnLike(token, user.get(position).getPostID());
                call.enqueue(new Callback<CResponse>() {
                    @Override
                    public void onResponse(Call<CResponse> call, Response<CResponse> response) {
                        CResponse data = response.body();

                        if(data.isStatus()){
                            Log.i("Success IG", data.getMessage());
                        }
                        else{
                            Log.e("Failed IG", data.getMessage());
                        }
                    }

                    @Override
                    public void onFailure(Call<CResponse> call, Throwable t) {
                        Log.d("Failed IG", t.getMessage());
                    }
                });

                user.get(position).setTotalLikes(user.get(position).getTotalLikes()-1);
                int totalLikes = user.get(position).getTotalLikes();
                if (totalLikes == 0)
                    _holder.count_likes.setVisibility(View.GONE);

                else if (totalLikes == 1)
                    _holder.count_likes.setText(1 + " like");

                else
                    _holder.count_likes.setText(totalLikes + " likes");

            }
        });

        Picasso
                .with(context)
                .load(ApiRetrofit.URL + _post.getImagePath())
                .resize(dpToPx(300), dpToPx(300))
                .centerCrop()
                .error(R.drawable.ic_account_circle_black_128dp)
                .into(_holder.photo);

        /** Caption or Content */
        if(_post.getContent() == "")
            _holder.username_caption.setVisibility(View.GONE);

        else {
            _holder.username_caption.setVisibility(View.VISIBLE);
            _holder.username_caption.setText(_post.getUserName());
            _holder.caption.setVisibility(View.VISIBLE);
            _holder.caption.setText(_post.getContent());
        }

        /** Location */
        if(_post.getLocation() == "")
            _holder.user_location.setVisibility(View.GONE);

        else {
            _holder.user_location.setVisibility(View.VISIBLE);
            _holder.user_location.setText(_post.getLocation());
        }

        try {
            _holder.time.setText(getTimeAgo(DatetimeUtils.stringToDate(_post.getCreatedOn()).getTime()));
        } catch (ParseException e) {
            e.printStackTrace();
        }
    }

    private int dpToPx(int dp) {
        float density = context.getResources().getDisplayMetrics().density;
        return Math.round((float) dp * density);
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
    public void insert(int position, PostResponse data) {
        user.add(position, data);
        notifyItemInserted(position);
    }

    // Remove a RecyclerView item containing a specified Data_Follow object
    public void remove(Data_TL data) {
        int position = user.indexOf(data);
        user.remove(position);
        notifyItemRemoved(position);
    }

    public class ViewHolder extends RecyclerView.ViewHolder {

        TextView nama, title_advertisement, time, username_caption, count_likes, caption, user_location, view_comment;
        ImageView pp, comment, photo;
        LikeButton like;

        public ViewHolder(View itemView) {
            super(itemView);
            nama = (TextView) itemView.findViewById(R.id.nama_detail);
            pp = (ImageView) itemView.findViewById(R.id.pp_timeline);
            comment = (ImageView) itemView.findViewById(R.id.icon_comment);
            view_comment = (TextView) itemView.findViewById(R.id.comments);
            like = (LikeButton) itemView.findViewById(R.id.icon_like);
            title_advertisement = (TextView) itemView.findViewById(R.id.title_advertisement);
            time = (TextView) itemView.findViewById(R.id.time);
            photo = (ImageView) itemView.findViewById(R.id.photo_area);
            username_caption = (TextView) itemView.findViewById(R.id.username_caption);
            count_likes = (TextView) itemView.findViewById(R.id.count_likes);
            caption = (TextView) itemView.findViewById(R.id.photo_caption);
            user_location = (TextView) itemView.findViewById(R.id.photo_location);
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

