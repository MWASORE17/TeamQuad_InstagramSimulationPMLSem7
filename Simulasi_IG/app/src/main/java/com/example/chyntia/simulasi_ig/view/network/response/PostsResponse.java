package com.example.chyntia.simulasi_ig.view.network.response;

import com.example.chyntia.simulasi_ig.view.network.model.PostDetail;

import java.util.ArrayList;

/**
 * Created by Vinixz on 12/11/2017.
 */

public class PostsResponse extends CResponse{
    private ArrayList<PostDetail> data;

    public PostsResponse(String message, boolean status) {
        super(message, status);
    }

    public PostsResponse(String message, boolean status, ArrayList<PostDetail> feeds) {
        super(message, status);
        this.data = feeds;
    }

    public ArrayList<PostDetail> getFeeds() {
        return data;
    }

    public void setFeeds(ArrayList<PostDetail> feeds) {
        this.data = feeds;
    }
}
