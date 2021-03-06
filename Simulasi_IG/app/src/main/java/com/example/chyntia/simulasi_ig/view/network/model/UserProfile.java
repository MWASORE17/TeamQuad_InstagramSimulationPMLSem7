package com.example.chyntia.simulasi_ig.view.network.model;

/**
 * Created by Vinixz on 12/20/2017.
 */

public class UserProfile {
    private int id;
    private String UserName;
    private String Name;
    private String Email;
    private String Password;
    private String ImagePath;
    private String Token;
    private int TotalFollowers;
    private int TotalFollowing;
    private int TotalPosts;


    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return Name;
    }

    public void setName(String name) {
        this.Name = name;
    }

    public String getEmail() {
        return Email;
    }

    public void setEmail(String email) {
        this.Email = email;
    }

    public String getPassword() {
        return Password;
    }

    public void setPassword(String password) {
        this.Password = password;
    }

    public String getUserName() {
        return UserName;
    }

    public void setUserName(String userName) {
        UserName = userName;
    }

    public String getImagePath() {
        return ImagePath;
    }

    public void setImagePath(String imagePath) {
        ImagePath = imagePath;
    }

    public String getToken() {
        return Token;
    }

    public void setToken(String token) {
        Token = token;
    }

    public int getTotalFollowers() {
        return TotalFollowers;
    }

    public void setTotalFollowers(int totalFollowers) {
        TotalFollowers = totalFollowers;
    }

    public int getTotalFollowing() {
        return TotalFollowing;
    }

    public void setTotalFollowing(int totalFollowing) {
        TotalFollowing = totalFollowing;
    }

    public int getTotalPosts() {
        return TotalPosts;
    }

    public void setTotalPosts(int totalPosts) {
        TotalPosts = totalPosts;
    }
}
