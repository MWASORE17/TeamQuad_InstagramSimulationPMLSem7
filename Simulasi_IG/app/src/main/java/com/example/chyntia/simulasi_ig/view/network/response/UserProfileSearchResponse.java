package com.example.chyntia.simulasi_ig.view.network.response;

import com.example.chyntia.simulasi_ig.view.network.model.UserProfile;
import com.example.chyntia.simulasi_ig.view.network.model.UserProfileSearch;

/**
 * Created by Vinixz on 12/20/2017.
 */

public class UserProfileSearchResponse extends CResponse{

    private UserProfileSearch data;

    public UserProfileSearchResponse(String message, boolean status) {
        super(message, status);
    }

    public UserProfileSearch getData() {
        return data;
    }

    public void setData(UserProfileSearch data) {
        this.data = data;
    }
}
