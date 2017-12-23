package com.example.chyntia.simulasi_ig.view.adapter;

import android.content.Context;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.util.Log;

import com.example.chyntia.simulasi_ig.R;
import com.example.chyntia.simulasi_ig.view.fragment.user.TabDetailFragment;
import com.example.chyntia.simulasi_ig.view.fragment.user.TabFollowingFragment;
import com.example.chyntia.simulasi_ig.view.fragment.user.TabGridFragment;
import com.example.chyntia.simulasi_ig.view.fragment.user.TabYouFragment;

/**
 * Created by Chyntia on 5/26/2017.
 */

public class ProfileVPAdapter extends FragmentPagerAdapter {
    final int PAGE_COUNT = 2;
    private Context context;
    private String token;

    public ProfileVPAdapter(FragmentManager fm) {
        super(fm);
    }

    public ProfileVPAdapter(FragmentManager fm, String token) {
        super(fm);
        this.token = token;
    }

    // Returns total number of pages
    @Override
    public int getCount() {
        return PAGE_COUNT;
    }

    // Returns the fragment to display for that page
    @Override
    public Fragment getItem(int position) {
        switch(position){
            case 0:
                Log.i("tes_post2", "case 0" + token);
                return TabGridFragment.newInstance(token);
            case 1:
                return TabDetailFragment.newInstance(token);
            default:
                return null;
        }
    }

    // Returns the page title for the top indicator
    @Override
    public CharSequence getPageTitle(int position) {
        return null;
    }
}
