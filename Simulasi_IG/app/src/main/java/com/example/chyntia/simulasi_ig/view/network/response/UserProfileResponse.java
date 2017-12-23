package com.example.chyntia.simulasi_ig.view.network.response;

import com.example.chyntia.simulasi_ig.view.network.model.UserProfile;

/**
 * Created by Vinixz on 12/20/2017.
 */

public class UserProfileResponse extends CResponse{

    private UserProfile data;

    public UserProfileResponse(String message, boolean status) {
        super(message, status);
    }

    public UserProfile getData() {
        return data;
    }

    public void setData(UserProfile data) {
        this.data = data;
    }
}
