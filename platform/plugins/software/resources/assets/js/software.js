$(document).ready(() => {
    BDashboard.loadWidget($('#widget_softwares_recent').find('.widget-content'), route('softwares.widget.recent-softwares'));
});
