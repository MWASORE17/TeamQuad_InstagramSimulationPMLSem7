package com.example.chyntia.simulasi_ig.view.network.model;

/**
 * Created by Vinixz on 12/20/2017.
 */

public class Comment {
    private int id;
    private int post_id;
    private int user_id;
    private String content;
    private String created_on;
    private String username;
    private String user_image;

    public Comment(int post_id, int user_id, String content, String created_on, String username, String user_image) {
        this.post_id = post_id;
        this.user_id = user_id;
        this.content = content;
        this.created_on = created_on;
        this.username = username;
        this.user_image = user_image;
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

    public int getUser_id() {
        return user_id;
    }

    public void setUser_id(int user_id) {
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

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getUser_image() {
        return user_image;
    }

    public void setUser_image(String user_image) {
        this.user_image = user_image;
    }
}
