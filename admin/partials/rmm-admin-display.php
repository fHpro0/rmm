    <?php

    /**
     * Provide a admin area view for the plugin
     *
     * This file is used to markup the admin-facing aspects of the plugin.
     *
     * @link       https://github.com/fHpro0/rmm
     * @since      1.0.0
     *
     * @package    Rmm
     * @subpackage Rmm/admin/partials
     */

    $definedUrls = Rmm_Storage::LoadJsonFile(Rmm_Storage::RMM_Modify_Remote_URLS);
    $availableUrls = Rmm_Storage::LoadJsonFile(Rmm_Storage::RMM_Available_Remote_URLS);

    $remove = $_POST['remove'];
    $addURL = $_POST["addUrl"];
    $actionURL = $_POST["actionUrl"];
    if (isset($remove)) {
        $found = false;
        foreach ($definedUrls as $key => $url) {
            if ($url["uuid"] == $remove) {
                $found = true;
                Rmm_Storage::RemoveMetadata($url["uuid"], $url["type"]);
                array_splice($definedUrls, $key, 1);
                break;
            }
        }
        if ($found) {
            Rmm_Storage::SaveJsonFile($definedUrls, Rmm_Storage::RMM_Modify_Remote_URLS); ?>
            <div class="rounded-md bg-blue-50 p-4 mt-10">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Successfully removed the URL, the URL will not be removed from the Metadata!</h3>
                    </div>
                </div>
            </div>
        <?php
        } else { ?>
            <div class="rounded-md bg-red-50 p-4 mt-10">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Something went wrong, the URL can not be found!</h3>
                    </div>
                </div>
            </div>
        <?php
        }
    } else if (isset($addURL) && isset($actionURL)) {
        $getNewURL = Rmm_Storage::UrlStruct($addURL, $actionURL);
        if ($getNewURL !== null) {
            array_push($definedUrls, Rmm_Storage::UrlStruct($addURL, $actionURL));
            Rmm_Storage::SaveJsonFile($definedUrls, Rmm_Storage::RMM_Modify_Remote_URLS); ?>
            <div class="rounded-md bg-green-50 p-4 mt-10">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Successfully added new URL (<strong><?php echo $addURL; ?></strong>) to be removed from the Metadata!</h3>
                    </div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="rounded-md bg-red-50 p-4 mt-10">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">This URL can not be saved on this, it can only be removed!</h3>
                    </div>
                </div>
            </div>
        <?php

        }
    }

    if (isset($_GET["update"])) {
        Rmm_Storage::UpdateEveryMetadata();
        ?>
        <div class="rounded-md bg-green-50 p-4 mt-10">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Successfully updated every remote Metadata Content.</h3>
                </div>
            </div>
        </div>
    <?php
    }

    $filteredAvailableUrls = [];
    foreach ($availableUrls as $url) {
        if (Rmm_Storage::ExistsInArray($url, $definedUrls)) continue;
        array_push($filteredAvailableUrls, $url);
    }
    $availableUrls = $filteredAvailableUrls;
    ?>

    <!-- This file should primarily consist of HTML with a little bit of PHP. -->
    <div class="px-4 mt-10 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <svg class="h-14 w-14 mr-5" stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 14L3 14" stroke-width="1.5" stroke-linecap="round" />
                <path d="M11 18H3" stroke-width="1.5" stroke-linecap="round" />
                <path d="M3 6L13.5 6M20 6L17.75 6" stroke-width="1.5" stroke-linecap="round" />
                <path d="M20 10L9.5 10M3 10H5.25" stroke-width="1.5" stroke-linecap="round" />
                <path d="M 16.219 16.525 L 15.455 16.525 L 15.455 15.662 M 15.197 15.92 L 18.449 12.668 C 18.674 12.443 19.038 12.443 19.263 12.668 C 19.487 12.892 19.487 13.257 19.263 13.481 L 15.963 16.781 C 15.808 16.936 15.732 17.012 15.646 17.079 C 15.57 17.138 15.489 17.19 15.405 17.236 C 15.31 17.287 15.208 17.326 15.005 17.405 L 14.305 17.675 L 14.53 16.999 C 14.607 16.769 14.645 16.653 14.699 16.545 C 14.746 16.45 14.803 16.359 14.867 16.274 C 14.939 16.178 15.026 16.092 15.197 15.92 Z" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-semibold leading-6 text-gray-900">Remote Metadata Modifier</h1>
                <p class="mt-4 text-sm text-gray-700">A list of all the remote metadata urls, that should be removed.</p>
                <?php if (count($availableUrls) == 0) : ?>
                    <span class="inline-flex items-center gap-x-1.5 rounded-md bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">
                        <svg class="h-6 w-6 fill-yellow-500" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 12C19.5 16.1421 16.1421 19.5 12 19.5C7.85786 19.5 4.5 16.1421 4.5 12C4.5 7.85786 7.85786 4.5 12 4.5C16.1421 4.5 19.5 7.85786 19.5 12ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12ZM11.25 13.5V8.25H12.75V13.5H11.25ZM11.25 15.75V14.25H12.75V15.75H11.25Z" />
                        </svg>
                        Before you can add a new URL you must load one homepage site. If there is a remote Metadata Url, you can add it to be modified.
                    </span>
                <?php endif; ?>
            </div>
            <div class="sm:ml-16 sm:mt-0 sm:flex-none">
                <?php if (count($availableUrls) > 0) : ?>
                    <button type="button" onclick="toggleModal('addModal')" class="block rounded-md bg-green-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Add URL</button>
                <?php endif; ?>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">URL</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Action</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Remove</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <?php foreach ($definedUrls as $url) : ?>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><?php echo $url["url"]; ?></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?php echo $url["action"] == "save" ? 'Saving on server' : 'Remove from Metadata'; ?></td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a onclick="remove('<?php echo $url['uuid']; ?>')" class="text-indigo-600 hover:text-indigo-900 hover:cursor-pointer">Remove</a>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                if (count($definedUrls) == 0) :
                                ?>
                                    <tr>
                                        <td colspan="3" class="text-center whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">No URL is defined, to be removed from the Metadata!</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="sm:flex sm:items-center mt-10">
            <div class="sm:flex-auto">
                <h1 class="text-2xl mb-4 font-semibold leading-6 text-gray-900">
                    Update Remote Metadata Content
                </h1>
                <div class="rounded-md bg-blue-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0 my-3">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="my-1 text-sm text-gray-700">Create a cronjob to automatically update remote Metadata Content. The example updates the content every day at 00:00</p>
                            <code>
                                0 0 */1 * * <?php echo get_site_url(); ?>/wp-json/rmm/v1/metadata/update?key=<?php echo get_option(Rmm_Helper::RMM_Secret_Key); ?> > /dev/null 2>&1
                            </code>
                        </div>
                    </div>
                </div>

            </div>
            <div class="sm:ml-16 sm:mt-0 sm:flex-none">
                <a href="?page=rmm-options&update" class="block rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 hover:cursor-pointer">Update Metadata Content now</a>
            </div>
        </div>
    </div>

    <div class="relative z-10 hidden" id="removeModal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <form class="fixed inset-0 z-10 w-screen overflow-y-auto" action="?page=rmm-options" method="POST">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Remove Metadata URL</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to remove this Metadata URL?</p>
                            </div>
                        </div>
                        <input class="hidden" name="remove" id="removeInput"></input>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 hover:text-white hover:cursor-pointer sm:ml-3 sm:w-auto">Remove</button>
                        <a type="button" onclick="toggleModal('removeModal')" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="relative z-10 hidden" id="addModal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <form class="fixed inset-0 z-10 w-screen overflow-y-auto" action="?page=rmm-options" method="POST">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Modify Remote URL</h3>
                        </div>
                        <div class="mt-3 w-full">
                            <label for="addUrl" class="block text-sm font-medium leading-6 text-gray-900">URLs</label>
                            <select id="addUrl" required name="addUrl" class="mt-2 block w-full max-w-full rounded-xl border-2 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <?php foreach ($availableUrls as $available) : ?>
                                    <option value="<?php echo $available; ?>"><?php echo $available; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mt-3 w-full">
                            <label for="actionUrl" class="block text-sm font-medium leading-6 text-gray-900">Action</label>
                            <select id="actionUrl" required name="actionUrl" class="mt-2 block w-full max-w-full rounded-xl border-2 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option selected value="remove">Remove</option>
                                <option value="save">Save on server</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                        <button type="submit" ac class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 sm:col-start-2">Add URL</button>
                        <a onclick="toggleModal('addModal')" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0 hover:cursor-pointer">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>