<?php include $this->resolve('partials/_header.php'); ?>

<section class="container mt-3">
    <div class="row">
        <section style="background-color: #eee;">
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                        <h5 class="font-weight-bold mb-3 text-center text-lg-start">Member</h5>
                        <div class="card">
                            <div class="card-body" style="max-height: 35em; overflow-y: scroll;">
                                <ul class="list-unstyled mb-0" id="leftChatBox">
                                    <?php $currUser = $user['id']; ?>
                                    <?php foreach ($friends as $friend) : ?>
                                        <?php $friendId = $friend['sID'] == $currUser ? $friend['rID'] : $friend['sID']; ?>
                                        <li class="p-2 border-bottom" style="<?= $room == $friendId ? 'background-color: #eee;' : '' ?>" id="<?= $friendId ?>">
                                            <a href="/chat/<?= $friendId ?>" class="d-flex justify-content-between text-decoration-none">
                                                <div class="d-flex flex-row">
                                                    <img src="/<?= $friend['pfp'] ?>" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                                    <div class="pt-1">
                                                        <p class="fw-bold mb-0"><?= $friend['fname'] . " " . $friend['lname'] ?></p>
                                                        <p class="small text-muted">
                                                            <?php if (isset($friend['lastMessage'])) : ?>
                                                                <?= $friend['lastMessage']['content'] ?>
                                                            <?php else : ?>
                                                                No messages yet
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="pt-1">
                                                    <p class="small text-muted mb-1">
                                                        <?php if (isset($friend['lastMessage'])) : ?>
                                                            <?= $friend['lastMessage']['time'] ?>
                                                        <?php endif; ?>
                                                    </p>
                                                    <?php if (
                                                        isset($friend['lastMessage']['seen'])
                                                        && $friend['lastMessage']['seen'] == 0
                                                        && $friend['lastMessage']['receiverId'] == $currUser
                                                    ) : ?>
                                                        <span class="badge bg-danger float-end">
                                                            1
                                                        </span>
                                                    <?php endif; ?>

                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                    <!-- ---------------------- -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-7 col-xl-8" id="chat-box-div" style="max-height: 35em; overflow-y: scroll;">
                        <?php if (empty($room)) : ?>
                            <div class="alert alert-info" role="alert">
                                <h4 class="alert-heading">Welcome to Chat!</h4>
                                <p>Click on a friend to start chatting with them.</p>
                                <hr>
                                <p class="mb-0">You can chat with your friends here.</p>
                            </div>
                        <?php else : ?>
                            <ul class="list-unstyled" id="chatMessagesBox">
                                <li class="d-flex justify-content-between mb-4">
                                    <div class="card w-100">
                                        <div class="card-header d-flex justify-content-between p-3">
                                            <p class="fw-bold mb-0">Lara Croft</p>
                                            <p class="text-muted small mb-0"><i class="far fa-clock"></i> 13 mins ago</p>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">

                                            </p>
                                        </div>
                                    </div>
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-5.webp" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
                                </li>

                            </ul>
                            <form action="" id="chatForm">
                                <input type="hidden" name="me" id="myId" value="<?php echo $user['id']; ?>">
                                <div data-mdb-input-init class="">
                                    <label class="form-label" for="messageBox">Message</label>
                                    <input style="height: 40px" class="form-control" id="messageBox" name="message" />
                                    <div class="invalid-feedback" id="messageBoxError">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info btn-rounded float-end my-2">Send</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

<?php if (isset($room)) : ?>
    <script>
        const room = <?= $room; ?>;
    </script>
    <script src="/assets/js/chat.js"></script>
<?php endif; ?>

<?php include $this->resolve('partials/_footer.php'); ?>