import Vuex from 'vuex';

import createPersistedState from 'vuex-persistedstate';

export default new Vuex.Store({
  plugins: [createPersistedState()],
  state: {
    isUserAuthenticated: false,
    userAccessToken: null,
  },
  mutations: {
    SET_USER_AUTHENTICATED: (state, isUserAuthenticated) => {
      state.isUserAuthenticated = isUserAuthenticated;
    },
    SET_USER_ACCESS_TOKEN: (state, userAccessToken) => {
      state.userAccessToken = userAccessToken;
    },
  },
  actions: {
    setUserAuthenticated: ({ commit }, isUserAuthenticated) => {
      commit('SET_USER_AUTHENTICATED', isUserAuthenticated);
    },
    setUserAccessToken: ({ commit }, userAccessToken) => {
      commit('SET_USER_ACCESS_TOKEN', userAccessToken);
    },
  },
});
