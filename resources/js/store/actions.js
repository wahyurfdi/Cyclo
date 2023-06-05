export const updateTrashQty = ({ commit }, { type, idx }) => {
    commit('UPDATE_TRASH_QTY', { type, idx })
}