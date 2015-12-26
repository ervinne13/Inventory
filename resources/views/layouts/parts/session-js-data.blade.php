
<script type="text/javascript">
    var session = {};

    session.currentUser = JSON.parse('{!! Auth::user() !!}');
    session.roleCodes = [];

    for (var i in session.currentUser.roles) {
        session.roleCodes.push(session.currentUser.roles[i].code);
    }

    session.hasRole = function (roleCode) {        
        return session.roleCodes.indexOf(roleCode) >= 0;
    };

</script>
