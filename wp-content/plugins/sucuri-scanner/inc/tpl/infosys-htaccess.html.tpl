
<div class="sucuriscan-panelstuff sucuriscan-infosys-htaccess">
    <div class="postbox sucuriscan-border sucuriscan-table-description">
        <h3>Access File Integrity</h3>

        <div class="inside">
            <p>
                The <code>.htaccess</code> is a distributed configuration file, and is how the
                Apache web server handles configuration changes on a per-directory basis.
                WordPress uses this file to manipulate how Apache serves files from its root
                directory and subdirectories thereof; most notably, it modifies this file to be
                able to handle pretty permalinks.
            </p>

            <div class="sucuriscan-inline-alert-updated sucuriscan-%%SUCURI.HTAccess.FoundVisible%%">
                <p>HTAccess file found in this path <code>%%SUCURI.HTAccess.Fpath%%</code></p>
            </div>

            <div class="sucuriscan-inline-alert-error sucuriscan-%%SUCURI.HTAccess.NotFoundVisible%%">
                <p>Your website has no <code>.htaccess</code> file or it was not found in the default location.</p>
            </div>

            <div class="sucuriscan-inline-alert-info sucuriscan-%%SUCURI.HTAccess.StandardVisible%%">
                <p>
                    The main <code>.htaccess</code> file in your site has the standard rules for a
                    WordPress installation. You can customize it to improve the performance and
                    change the behaviour of the redirections for pages and posts in your site. To
                    get more information visit the official documentation at <a target="_blank"
                    href="https://codex.wordpress.org/Using_Permalinks#Creating_and_editing_.28.htaccess.29">
                    Codex WordPrexx - Creating and editing (.htaccess)</a>
                </p>
            </div>

            <textarea class="sucuriscan-full-textarea sucuriscan-monospace %%SUCURI.HTAccess.TextareaVisible%%">%%SUCURI.HTAccess.Content%%</textarea>

            <p>
                <small>Source <a href="https://codex.wordpress.org/htaccess" target="_blank">Codex WordPress HTAccess</a></small>
            </p>
        </div>
    </div>
</div>
