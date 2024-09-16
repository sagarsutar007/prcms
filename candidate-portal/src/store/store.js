import { configureStore } from "@reduxjs/toolkit";
import authReducer from "../features/auth/authSlice";
import examReducer from '../features/exam/examSlice';

const store = configureStore({
	reducer: {
		auth: authReducer,
		exam: examReducer,
	},
});

export default store;
