package com.example.chyntia.simulasi_ig.view.network.model;

import com.example.chyntia.simulasi_ig.view.network.response.CResponse;

/**
 * Created by Vinixz on 12/6/2017.
 */

public class PostDetail  {

    private String UserName;
    private int PostID;
    private int UserId;
    private String UserImagePath;
    private String ImagePath;
    private String Content;
    private String Location;
    private String CreatedOn;
    private int TotalComment;
    private int TotalLikes;
    private int IsUnlike;

    public String getUserName() {
        return UserName;
    }

    public void setUserName(String userName) {
        UserName = userName;
    }

    public int getPostID() {
        return PostID;
    }

    public void setPostID(int postID) {
        PostID = postID;
    }

    public int getUserId() {
        return UserId;
    }

    public void setUserId(int userId) {
        UserId = userId;
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

    public int getTotalComment() {
        return TotalComment;
    }

    public void setTotalComment(int totalComment) {
        TotalComment = totalComment;
    }

    public int getTotalLikes() {
        return TotalLikes;
    }

    public void setTotalLikes(int totalLikes) {
        TotalLikes = totalLikes;
    }

    public int getIsUnlike() {
        return IsUnlike;
    }

    public void setIsUnlike(int isUnlike) {
        IsUnlike = isUnlike;
    }

    public String getUserImagePath() {
        return UserImagePath;
    }

    public void setUserImagePath(String userImagePath) {
        UserImagePath = userImagePath;
    }
}
