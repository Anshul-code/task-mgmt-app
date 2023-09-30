import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
  state () {
    return {
      btoken: localStorage.getItem('btoken') || null
    }
  },
  mutations: {
    updateBToken(state, payload) {
        state.btoken = payload;
    },
    deleteBToken(state) {
        state.btoken = null;
    }
  },
  actions: {
    setBToken (context,payload) {
        localStorage.setItem('btoken', payload);
        context.commit('updateBToken', payload); 
    },
    removeBToken(context) {
        localStorage.removeItem('btoken');
        context.commit('deleteBToken'); 
    }
  },
  getters: {
    getBToken() {
        return state.btoken;
    }
  }
})

export default store;