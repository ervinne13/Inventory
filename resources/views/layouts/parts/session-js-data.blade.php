
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

    session.getModuleAccess = function (moduleCode) {

        if (session.isAdmin) {
            return "MANAGER";
        } else {
            for (var i in session.currentUser.roles) {
                var role = session.currentUser.roles[i];
                for (var j in role.access_control_list) {
                    if (role.access_control_list[j].module_code == moduleCode) {
                        return role.access_control_list[j].access_control_code;
                    }
                }
            }

            return null;
        }
    };

    console.log(session.currentUser);

    session.isAdmin = session.hasRole("ADMIN");

</script>
