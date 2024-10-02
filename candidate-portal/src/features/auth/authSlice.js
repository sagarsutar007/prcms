// src/features/auth/authSlice.js
import { createSlice } from "@reduxjs/toolkit";

const initialState = {
    token: localStorage.getItem("token") || null,
    isAuthenticated: !!localStorage.getItem("token"),
    userDetails: JSON.parse(localStorage.getItem("userDetails")) || null,
};

const authSlice = createSlice({
    name: "auth",
    initialState,
    reducers: {
        loginSuccess: (state, action) => {
            state.token = action.payload.token;
            state.isAuthenticated = true;
            state.userDetails = action.payload.userDetails;
            localStorage.setItem("token", action.payload.token);
            localStorage.setItem("userDetails", JSON.stringify(action.payload.userDetails));
        },
        logout: (state) => {
            state.token = null;
            state.isAuthenticated = false;
            state.userDetails = null;
            localStorage.removeItem("token");
            localStorage.removeItem("userDetails");
        },
    },
});

export const { loginSuccess, logout } = authSlice.actions;
export default authSlice.reducer;
