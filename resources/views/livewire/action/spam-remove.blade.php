<x-modal-confirm
    livewire-event-to-open-modal="markAsNotSpamCommentWasSet"
    event-to-close-modal="commentWasMarkedAsNotSpam"
    modal-title="Remove This from spam list"
    modal-description="Are you sure you want to remove all spams? this cant be undone."
    modal-confirm-button-text="Remove All Spams"
    wire-click="removeAllSpams()"
/>
