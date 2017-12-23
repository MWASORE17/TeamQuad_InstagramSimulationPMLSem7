package com.example.chyntia.simulasi_ig.view.network.response;

import com.example.chyntia.simulasi_ig.view.model.entity.User;

import java.util.ArrayList;

/**
 * Created by Vinixz on 12/20/2017.
 */

public class SearchResponse extends CResponse{
    private ArrayList<User> data;

    public SearchResponse(String message, boolean status) {
        super(message, status);
    }

    public ArrayList<User> getData() {
        return data;
    }

    public void setData(ArrayList<User> data) {
        this.data = data;
    }
}
