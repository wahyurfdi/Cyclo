export const SET_TOKEN = (state, token) => {
    state.token = token
}

export const SHOW_TOAST = (state, message) => {
    state.toast.isShow = true
    state.toast.message = message

    setTimeout(() => {
        state.toast.isShow = false
    }, 3000)
}

export const UPDATE_TRASH_QTY = (state, { type, idx }) => {
    if(type == 'ADD') {
        state.trashTypes[idx].qty += 1
    } else {
        if(state.trashTypes[idx].qty > 0) state.trashTypes[idx].qty -= 1
    }
}