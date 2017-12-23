package com.example.chyntia.simulasi_ig.view.network.response;

import com.example.chyntia.simulasi_ig.view.model.entity.User;

import java.util.ArrayList;

/**
 * Created by Vinixz on 12/21/2017.
 */

public class UserFollowResponse extends CResponse{

    private ArrayList<User> data;

    public UserFollowResponse(String message, boolean status) {
        super(message, status);
    }

    public ArrayList<User> getData() {
        return data;
    }

    public void setData(ArrayList<User> data) {
        this.data = data;
    }
}
