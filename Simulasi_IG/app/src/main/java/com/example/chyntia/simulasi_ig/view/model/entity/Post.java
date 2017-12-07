package com.example.chyntia.simulasi_ig.view.model.entity;

/**
 * Created by Vinixz on 12/6/2017.
 */

public class Post {

    private int PostID;
    private String UserName;
    private String ImagePath;
    private String Content;
    private String Location;
    private String CreatedOn;

    public Post(){

    }

    public Post(int postID, String userName, String imagePath, String content, String location, String createdOn) {
        PostID = postID;
        UserName = userName;
        ImagePath = imagePath;
        Content = content;
        Location = location;
        CreatedOn = createdOn;
    }

    public int getPostID() {
        return PostID;
    }

    public void setPostID(int postID) {
        PostID = postID;
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

    public String getContent() {
        return Content;
    }

    public void setContent(String content) {
        Content = content;
    }

    public String getLocation() {
        return Location;
    }

    public void setLocation(String location) {
        Location = location;
    }

    public String getCreatedOn() {
        return CreatedOn;
    }

    public void setCreatedOn(String createdOn) {
        CreatedOn = createdOn;
    }
}
