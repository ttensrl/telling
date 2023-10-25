//Permette l'apertura corretta delle modali in Livewire
window.livewire.on('showDiffModal', () =>
{
    var diffModal = new bootstrap.Modal(document.getElementById('version-diff-modal'));
    diffModal.show();
});

//Permette la chiusura corretta delle modali in Livewire
window.livewire.on('hideDiffModal', () =>
{
    var diffModal = new bootstrap.Modal(document.getElementById('version-diff-modal'));
    diffModal.hide();
});
