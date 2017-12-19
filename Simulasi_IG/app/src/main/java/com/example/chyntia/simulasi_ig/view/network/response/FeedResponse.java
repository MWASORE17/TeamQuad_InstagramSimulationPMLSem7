package com.example.chyntia.simulasi_ig.view.network.response;

import java.util.ArrayList;

/**
 * Created by Vinixz on 12/11/2017.
 */

public class FeedResponse extends CResponse{
    private ArrayList<PostResponse> data;

    public FeedResponse(String message, boolean status) {
        super(message, status);
    }

    public FeedResponse(String message, boolean status, ArrayList<PostResponse> feeds) {
        super(message, status);
        this.data = feeds;
    }

    public ArrayList<PostResponse> getFeeds() {
        return data;
    }

    public void setFeeds(ArrayList<PostResponse> feeds) {
        this.data = feeds;
    }
}
