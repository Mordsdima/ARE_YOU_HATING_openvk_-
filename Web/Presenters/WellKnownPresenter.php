<?php declare(strict_types=1);
namespace openvk\Web\Presenters;
use openvk\Web\Models\Repositories\Users as UsersRepo;

final class WellKnownPresenter extends OpenVKPresenter
{
    function renderWebfinger(): void
    {
        header("Content-Type: application/json");
        if($this->queryParam("resource")) {
            list($username, $domain) = explode("@", str_replace("acct:", "", $this->queryParam("resource")));
            $d2 = OPENVK_ROOT_CONF['openvk']['preferences']['domain'];
            if($d2 != $domain) {
                # Resolving user of other server? Well we dont yet implement that
                exit(json_encode([ "not" => "implemented" ]));
            }
            $users = new UsersRepo;
            $user = $users->get((int)filter_var($username, FILTER_SANITIZE_NUMBER_INT));
            if($user) {
                exit(json_encode([ "subject" => $this->queryParam("resource"), "aliases" => [], "links" => [
                    [ "rel" => "http://webfinger.net/rel/profile-page", "type" => "text/html", "href" => "https://$domain/$username" ],
                    [ "rel" => "self", "type" => "application/activity+json", "href" => "https://$domain/$username" ]
                ]]));
            } else {
                header("HTTP/1.1 404 Not Found");
                exit(json_encode([]));
            }
            
        } else {
            exit(json_encode([  ]));
        }
    }
}
