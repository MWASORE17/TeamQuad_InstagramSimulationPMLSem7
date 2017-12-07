package com.example.chyntia.simulasi_ig.view.model.entity;

/**
 * Created by Chyntia on 6/15/2017.
 */

public class Data_Comments {
    public String username_comments, profPic, comments_content, created_at;

    private int id;
    private int post_id;
    private String user_id;
    private String content;
    private String created_on;

    public Data_Comments(String profPic, String username_comments, String comments_content, String created_at){
        this.profPic =  profPic;
        this.username_comments = username_comments;
        this.comments_content = comments_content;
        this.created_at = created_at;
    }

    public Data_Comments(int id, int post_id, String user_id, String content, String created_on) {
        this.id = id;
        this.post_id = post_id;
        this.user_id = user_id;
        this.content = content;
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

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public String getCreated_on() {
        return created_on;
    }

    public void setCreated_on(String created_on) {
        this.created_on = created_on;
    }
}
