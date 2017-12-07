package com.example.chyntia.simulasi_ig.view.model.entity;

/**
 * Created by Chyntia on 6/17/2017.
 */

public class Data_Likes {
    public String username, profPic, created_at;

    private int id, post_id;
    private String user_id, created_on;

    public Data_Likes(String profPic, String username, String created_at){
        this.profPic =  profPic;
        this.username = username;
        this.created_at = created_at;
    }

    public Data_Likes(int id, int post_id, String user_id, String created_on) {
        this.id = id;
        this.post_id = post_id;
        this.user_id = user_id;
        this.created_on = created_on;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getPost_id() {
        return post_id;
    }

    public void setPost_id(int post_id) {
        this.post_id = post_id;
    }

    public String getUser_id() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }

    public String getCreated_on() {
        return created_on;
    }

    public void setCreated_on(String created_on) {
        this.created_on = created_on;
    }
}
