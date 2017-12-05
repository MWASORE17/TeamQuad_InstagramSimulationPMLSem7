package com.example.chyntia.simulasi_ig.view.model.entity;

/**
 * Created by Chyntia on 6/7/2017.
 */

public class User {
    private int id;
    private String UserName;
    private String Name;
    private String Email;
    private String Password;
    private String ImagePath;
    private String Token;

    public User(String userName, String name, String email, String password, String imagePath, String token) {
        UserName = userName;
        Name = name;
        Email = email;
        Password = password;
        ImagePath = imagePath;
        Token = token;
    }

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
}
