import router from './../router'

export const checkRequestError = ({ commit }, error) => {
    if(error.response) {
        if(error.response.status == 401) {
            localStorage.removeItem('token')

            router.push('/web-app/login')
        } else {
            commit('SHOW_TOAST', error.response.data.message)
        }
    }
}

export const setProfile = ({ commit }, profile) => {
    commit('SET_PROFILE', profile)
}

export const setToken = ({ commit }, token) => {
    commit('SET_TOKEN', token)
}

export const showToast = ({ commit }, message) => {
    commit('SHOW_TOAST', message)
}

export const updateTrashQty = ({ commit }, { type, idx }) => {
    commit('UPDATE_TRASH_QTY', { type, idx })
}