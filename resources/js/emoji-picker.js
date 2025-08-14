export default function emojiReactionForm(distractionId) {
    return {
        pickerVisible: false,
        togglePicker() {
            this.pickerVisible = !this.pickerVisible;
        },
        submitEmoji(event) {
            const emoji = event.detail.unicode;
            this.$refs.input.value = emoji;
            this.$refs.form.submit();
            this.pickerVisible = false;
        },
    };
}
