package com.example.chyntia.simulasi_ig.view.adapter;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.model.entity.Data_Follow;
import com.example.chyntia.simulasi_ig.view.model.entity.session.SessionManager;
import com.example.chyntia.simulasi_ig.view.network.ApiRetrofit;
import com.example.chyntia.simulasi_ig.view.network.model.Comment;
import com.example.chyntia.simulasi_ig.view.utilities.DatetimeUtils;
import com.squareup.picasso.Picasso;

import java.io.File;
import java.text.ParseException;
import java.util.HashMap;
import java.util.List;

/**
 * Created by Chyntia on 6/14/2017.
 */

public class UserCommentRVAdapter extends RecyclerView.Adapter<RecyclerView.ViewHolder> {
    List<Comment> user;
    Context context;
    private boolean isButtonClicked = false;
//    LoginDBAdapter loginDBAdapter;
    SessionManager session;
    String userName;

    public UserCommentRVAdapter(List<Comment> user, Context context) {
        this.user = user;
        this.context = context;
    }

    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        //Inflate the layout, initialize the View Holder
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.custom_row_comment, parent, false);


        session = new SessionManager(context);
        HashMap<String, String> user = session.getUserDetails();

        userName = user.get(SessionManager.KEY_USERNAME);

        return new UserCommentRVAdapter.ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(RecyclerView.ViewHolder holder,int position) {
        final UserCommentRVAdapter.ViewHolder _holder = (UserCommentRVAdapter.ViewHolder) holder;
        final Comment _user = this.user.get(position);
        //Use the provided View Holder on the onCreateViewHolder method to populate the current row on the RecyclerView
        _holder.nama.setText(_user.getUsername());

        if(_user.getContent() != ""){
            Picasso
                    .with(context)
                    .load(ApiRetrofit.URL + _user.getUser_image())
                    .resize(dpToPx(20), dpToPx(20))
                    .centerCrop()
                    .error(R.drawable.ic_account_circle_black_24dp)
                    .into(_holder.pp);
        }
        else
            _holder.pp.setImageResource(R.drawable.ic_account_circle_black_24dp);

        try {
            _holder.created_at.setText(HomeRVAdapter.getTimeAgo(DatetimeUtils.stringToDate(_user.getCreated_on()).getTime()));
        } catch (ParseException e) {
            e.printStackTrace();
        }
        _holder.comments_content.setText(_user.getContent());
        //animate(holder);
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

    public void add(Comment data){
        user.add(data);
        notifyDataSetChanged();
    }

    // Insert a new item to the RecyclerView on a predefined position
    public void insert(int position, Comment data) {
        user.add(position, data);
        notifyItemInserted(position);
    }

    // Remove a RecyclerView item containing a specified Data_Follow object
    public void remove(Data_Follow dataFollow) {
        int position = user.indexOf(dataFollow);
        user.remove(position);
        notifyItemRemoved(position);
    }

    public class ViewHolder extends RecyclerView.ViewHolder {

        TextView nama, created_at, comments_content;
        ImageView pp;

        public ViewHolder(View itemView) {
            super(itemView);
            nama = (TextView) itemView.findViewById(R.id.username_comment);
            pp = (ImageView) itemView.findViewById(R.id.pp_comment);
            created_at = (TextView) itemView.findViewById(R.id.time_comment);
            comments_content = (TextView) itemView.findViewById(R.id.comments_content);
        }
    }
}
