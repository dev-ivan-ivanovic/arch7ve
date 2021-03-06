/******************************************************************************
"Arch7ve" an open-source web app for document archiving written using "co7e" the open-source web framework.
Copyright (C) 2021  Ivan Ivanovic

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
******************************************************************************/


function isSuperuser() {
    co7e.crud({script:"arch7ve/server/is-superuser.php"}).then(data => {
        if (data) {       
            co7e.superuserArea(true);
        } else {
            co7e.superuserArea(false);
        }
    });
}

function isSignedIn() {
    co7e.crud({script:"arch7ve/server/is-signed-in.php"}).then(data => {
        if (data) {
            btnSignInSignOut.textContent = 'Sign out';
            btnSignInSignOut.onclick = () => signOut();
            
            enumerateUser();
            enumerateGroup();
            enumerateUserGroup();
            
            co7e.view('view-group-1', 'archiveView');       
            co7e.memberArea(true);
        } else {
            btnSignInSignOut.textContent = 'Sign in';
            btnSignInSignOut.onclick = e => co7e.view('view-group-1', 'signInView');
            
            enumerateUser();
            enumerateGroup();
            enumerateUserGroup();
            
            co7e.view('view-group-1', 'signInView');
            co7e.memberArea(false);
        }
    });
}

function enumerateUser() {
    co7e.crud({script:"arch7ve/server/enumerate-user.php"}).then(data => {
        co7e.render(lstUsers, tmplUserListItem, data);
        co7e.render(cboUsers, tmplUserOption, data);
    });
}

function enumerateGroup() {
    co7e.crud({script:"arch7ve/server/enumerate-group.php"}).then(data => {
        co7e.render(lstGroups, tmplGroupListItem, data);
        co7e.render(cboGroups, tmplGroupOption, data);
    });
}

function enumerateUserGroup() {
    co7e.crud({script:"arch7ve/server/enumerate-user-group.php"}).then(data => {
        co7e.render(lstUsersGroups, tmplUserGroupListItem, data);
    });
}

function enumerateCurrentUserGroup() {
    co7e.crud({script:"arch7ve/server/enumerate-current-user-group.php"}).then(data => {
        for (let cbo of document.querySelectorAll('[data-id="cboCurrentUserGroup"]')) {
            co7e.render(cbo, tmplGroupOption, data);
        } 
    });
}

function signOut() {
    co7e.crud({script:"arch7ve/server/sign-out.php"}).then(data => {
        if (data) {
            window.alert('User sign out succeeded.');
        } else {
            window.alert('User sign out failed.');
        }
        
        isSignedIn();
        isSuperuser();
    });
}

isSignedIn();
isSuperuser();

function signIn(sender, e) {
    if (co7e.submit(e)) {
        co7e.crud({script:"arch7ve/server/sign-in.php", dataSource:e.target.form}).then(data => {
            if (data) {
                e.target.form.reset();
                window.alert('User authentication succeeded.');
            } else {
                window.alert('User authentication failed.');
            }
            
            isSignedIn();
            isSuperuser();
        });
    }
}

function createUser(sender, e) {
    if (co7e.submit(e)) {
        if (window.confirm('Create user?')) {
            co7e.crud({script:"arch7ve/server/create-user.php", dataSource:e.target.form}).then(data => {
                if (data) {
                    e.target.form.reset();
                    enumerateUser();
                    window.alert('User creation succeeded.');
                } else {
                    window.alert('User creation failed.');
                } 
            });
        }
    }
}

function createGroup(sender, e) {
    if (co7e.submit(e)) {
        if (window.confirm('Create group?')) {
            co7e.crud({script:"arch7ve/server/create-group.php", dataSource:e.target.form}).then(data => {
                if (data) {
                    e.target.form.reset();
                    enumerateGroup();
                    window.alert('Group creation succeeded.');
                } else {
                    window.alert('Group creation failed.');
                }
            });
        }
    }   
}

function linkUserGroup(sender, e) {
    if (co7e.submit(e)) {
        co7e.crud({script:"arch7ve/server/link-user-group.php", dataSource:e.target.form}).then(data => {
            if (data) {
                enumerateUserGroup();
                window.alert('User/Group linking succeeded.');
            } else {
                window.alert('User/Group linking failed.');
            }
        });
    }
}

function unlinkUserGroup(sender, e) {
    if (co7e.submit(e)) {
        co7e.crud({script:"arch7ve/server/unlink-user-group.php", dataSource:e.target.form}).then(data => {
            if (data) {
                enumerateUserGroup();
                window.alert('User/Group unlinking succeeded.');
            } else {
                window.alert('User/Group unlinking failed.');
            }
        });
    }
}

function filterUser(sender, e) {
    if (co7e.submit(e)) {
        co7e.crud({script:"arch7ve/server/filter-user.php", dataSource:e.target.form}).then(data => {
            co7e.render(findUserResults, tmplUserForm, data);
            co7e.render(lstUsers, tmplUserListItem, data);
        });
    }
}

function updateUser(sender, e) {
    if (co7e.submit(e)) {
        if (window.confirm('Update user?')) {
            co7e.crud({script:"arch7ve/server/update-user.php", dataSource:e.target.form}).then(data => {
                if (data) {
                    e.target.form.reset();
                    enumerateUser();
                    window.alert('User updating succeeded.');
                } else {
                    window.alert('User updating failed.');
                }
            });
        }
    }
}

function deleteUser(sender, e) {
    if (co7e.submit(e)) {
        if (window.confirm('Delete user?')) {
            co7e.crud({script:"arch7ve/server/delete-user.php", dataSource:e.target.form}).then(data => {
                if (data) {
                    e.target.form.reset();
                    enumerateUser();
                    window.alert('User deletion succeeded.');
                } else {
                    window.alert('User deletion failed.');
                }
            });
        }
    }
}

function filterGroup(sender, e) {
    if (co7e.submit(e)) {
        co7e.crud({script:"arch7ve/server/filter-group.php", dataSource:e.target.form}).then(data => {
            co7e.render(findGroupResults, tmplGroupForm, data);
            co7e.render(lstGroups, tmplGroupListItem, data);
        });
    }
}

function deleteGroup(sender, e) {
    if (co7e.submit(e)) {
        if (window.confirm('Delete group?')) {
            co7e.crud({script:"arch7ve/server/delete-group.php", dataSource:e.target.form}).then(data => {
                if (data) {
                    e.target.form.reset();
                    enumerateGroup();
                    window.alert('Group deletion succeeded.');
                } else {
                    window.alert('Group deletion failed.');
                }
            });
        }
    }
}

function filterUserGroup(sender, e) {
    if (co7e.submit(e)) {
        co7e.crud({script:"arch7ve/server/filter-user-group.php", dataSource:e.target.form}).then(data => {
            co7e.render(lstUsersGroups, tmplUserGroupListItem, data);
        });
    }
}

function postNote(sender, e) {
    if (co7e.submit(e)) {
        if (window.confirm('Post note?')) {
            co7e.crud({upload:true,
            script:"arch7ve/server/create-note.php",
            dataSource:e.target.form,
            uploadProgressCallback:percentUploaded => e.target.form.querySelector("progress").value=percentUploaded
            }).then(data => {
                if (data) {
                    e.target.form.reset();
                    window.alert('Note posting succeeded.');
                } else {
                    window.alert('Note posting failed.');
                }
            });
        }
    }
}

function filterNote(sender, e) {
    if (co7e.submit(e)) {
        co7e.crud({script:"arch7ve/server/filter-note.php", dataSource:e.target.form}).then(data => {
            //co7e.render(findUserResults, tmplUserForm, data);
            co7e.render(lstNotes, tmplNoteListItem, data);
        });
    }
}

function loadAttachments(sender, e) {
    co7e.crud({script:"arch7ve/server/enumerate-attachments.php", dataSource:sender.form}).then(data => {
        co7e.render(sender.form.querySelector('[data-attachments]'), tmplAttachmentListItem, data);
    });
}