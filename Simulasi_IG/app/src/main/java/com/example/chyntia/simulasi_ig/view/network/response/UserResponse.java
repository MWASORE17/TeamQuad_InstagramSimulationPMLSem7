package com.example.chyntia.simulasi_ig.view.network.response;

import com.example.chyntia.simulasi_ig.view.model.entity.User;

/**
 * Created by Vinixz on 11/29/2017.
 */

public class UserResponse extends CResponse {
    private User data;

    public UserResponse(String message, boolean status) {
        super(message, status);
    }

    public UserResponse(String message, boolean status, User user) {
        super(message, status);
        this.data = user;
    }

    public User getUser() {
        return data;
    }

    public void setUser(User user) {
        this.data = user;
    }
}
