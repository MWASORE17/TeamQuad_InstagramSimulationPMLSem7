package com.example.chyntia.simulasi_ig.view.network.response;

import com.example.chyntia.simulasi_ig.view.model.entity.User;
import com.example.chyntia.simulasi_ig.view.network.model.UserProfileSearch;

import java.util.ArrayList;

/**
 * Created by Vinixz on 12/21/2017.
 */

public class UserFollowResponse extends CResponse{

    private ArrayList<UserProfileSearch> data;

    public UserFollowResponse(String message, boolean status) {
        super(message, status);
    }

    public ArrayList<UserProfileSearch> getData() {
        return data;
    }

    public void setData(ArrayList<UserProfileSearch> data) {
        this.data = data;
    }
}
