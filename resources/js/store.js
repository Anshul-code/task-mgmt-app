import { createStore } from 'vuex';

// Create a new store instance.
const store = createStore({
  state () {
    return {
      btoken: localStorage.getItem('btoken') || null,
      user: JSON.parse(localStorage.getItem('user')) || null,
    }
  },
  mutations: {
    updateBToken(state, payload) {
        state.btoken = payload;
    },
    deleteBToken(state) {
        state.btoken = null;
    },
    updateUser(state, payload) {
        state.user = payload;
    },
    deleteUser(state) {
        state.user = null;
    },
  },
  actions: {
    setBToken (context,payload) {
        localStorage.setItem('btoken', payload);
        context.commit('updateBToken', payload); 
    },
    removeBToken(context) {
        localStorage.removeItem('btoken');
        context.commit('deleteBToken'); 
    },
    setUser (context,payload) {
        localStorage.setItem('user', JSON.stringify(payload));
        context.commit('updateUser', payload); 
    },
    removeUser(context) {
        localStorage.removeItem('user');
        context.commit('deleteUser'); 
    },
  },
  getters: {
    getBToken(state) {
        return state.btoken;
    },
    getUser(state) {
        return state.user;
    },
  }
})

export default store;