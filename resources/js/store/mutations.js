export const UPDATE_TRASH_QTY = (state, { type, idx }) => {
    if(type == 'ADD') {
        state.trashTypes[idx].qty += 1
    } else {
        if(state.trashTypes[idx].qty > 0) state.trashTypes[idx].qty -= 1
    }
}