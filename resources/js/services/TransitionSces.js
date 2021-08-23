
export default {
    getArrayFormatted(transitions) {
        let arr = []
        for (var i = 0; i < transitions.length; i++) {
            arr[transitions[i].treatmenttype.code] = transitions.destination
        }
        return arr;
    }
}
