package com.example.chyntia.simulasi_ig.view.network.response;

import com.example.chyntia.simulasi_ig.view.model.entity.User;
import com.example.chyntia.simulasi_ig.view.network.model.Comment;

import java.util.ArrayList;

/**
 * Created by Vinixz on 12/20/2017.
 */

public class CommentResponse extends CResponse {

    private ArrayList<Comment> data;

    public CommentResponse(String message, boolean status) {
        super(message, status);
    }

    public ArrayList<Comment> getData() {
        return data;
    }

    public void setData(ArrayList<Comment> data) {
        this.data = data;
    }
}
