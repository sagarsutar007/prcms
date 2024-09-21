// src/features/auth/examSlice.js
import { createSlice } from '@reduxjs/toolkit';

const initialState = {
  questions: [],
  currentIndex: 0,
};

const examSlice = createSlice({
  name: 'exam',
  initialState,
  reducers: {
    setQuestions: (state, action) => {
      state.questions = action.payload;
    },
    nextQuestion: (state) => {
      if (state.currentIndex < state.questions.length - 1) {
        state.currentIndex += 1;
      }
    },
    prevQuestion: (state) => {
      if (state.currentIndex > 0) {
        state.currentIndex -= 1;
      }
    },
    goToQuestion: (state, action) => {
      state.currentIndex = action.payload;
    },
    setUserAnswer: (state, action) => {
      const { questionId, answerId } = action.payload;
      const question = state.questions.find(q => q.question_id === questionId);
      if (question) {
          question.userAnswer = answerId;
      }
    },
  },
});

export const { setQuestions, nextQuestion, prevQuestion, goToQuestion, setUserAnswer } = examSlice.actions;

export default examSlice.reducer;