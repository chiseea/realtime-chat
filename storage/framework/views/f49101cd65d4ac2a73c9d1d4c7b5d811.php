<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Realtime Chat</title>

    <meta name="csrf-token"
          content="<?php echo e(csrf_token()); ?>">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{

            height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            overflow:hidden;

            position:relative;

            background:
            linear-gradient(
                135deg,
                #022c22 0%,
                #064e3b 30%,
                #0f766e 65%,
                #0f766e 100%
            );
        }

        body::before{

            content:'';

            position:absolute;
            inset:0;

            background:

            radial-gradient(
                circle at 20% 20%,
                rgba(255,255,255,0.08),
                transparent 25%
            ),

            radial-gradient(
                circle at 80% 70%,
                rgba(255,255,255,0.06),
                transparent 25%
            ),

            radial-gradient(
                circle at 50% 50%,
                rgba(255,255,255,0.04),
                transparent 35%
            );

            filter:blur(45px);

            z-index:0;
        }

        body::after{

            content:'';

            position:absolute;
            inset:0;

            z-index:0;

            opacity:.08;

            background-image:

            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='220' height='220' viewBox='0 0 220 220'%3E%3Cg fill='none' stroke='white' stroke-opacity='0.8' stroke-width='2'%3E%3Ccircle cx='30' cy='30' r='18'/%3E%3Cpath d='M80 22 h40 v28 h-40 z'/%3E%3Cpath d='M150 35 q18-18 36 0'/%3E%3Cpath d='M22 90 h48 a8 8 0 0 1 8 8 v18 a8 8 0 0 1-8 8 h-20 l-10 10 v-10 h-18 a8 8 0 0 1-8-8 v-18 a8 8 0 0 1 8-8z'/%3E%3Ccircle cx='135' cy='105' r='15'/%3E%3Cpath d='M170 92 h28 v28 h-28 z'/%3E%3Cpath d='M28 165 q20-20 40 0 q20 20 40 0'/%3E%3Cpath d='M120 160 h50 v34 h-50 z'/%3E%3Ccircle cx='190' cy='175' r='7'/%3E%3C/g%3E%3C/svg%3E");

            background-size:220px;
        }

        .chat-container{

            width:390px;
            height:690px;

            border-radius:30px;

            overflow:hidden;

            background:
            rgba(255,255,255,0.14);

            backdrop-filter:blur(18px);

            border:
            1px solid rgba(255,255,255,0.14);

            box-shadow:
            0 20px 70px rgba(0,0,0,0.45);

            position:relative;

            z-index:2;

            display:flex;
            flex-direction:column;
        }

        .chat-header{

            background:
            rgba(255,255,255,0.97);

            padding:24px;
        }

        .chat-header h1{

            font-size:20px;
            color:#111827;

            margin-bottom:6px;
        }

        .status{

            display:flex;
            align-items:center;
            gap:7px;

            font-size:13px;
            color:#4b5563;
        }

        .status-dot{

            width:8px;
            height:8px;

            border-radius:50%;

            background:#22c55e;
        }

        /* REVISI WARNA DALAM CHAT */

        #chat{

            flex:1;

            overflow-y:auto;

            padding:18px;

            display:flex;
            flex-direction:column;

            gap:14px;

            background:

            linear-gradient(
                180deg,
                #2dd4bf 0%,
                #5eead4 55%,
                #99f6e4 100%
            );
        }

        #chat::-webkit-scrollbar{
            width:0;
        }

        .message{

            display:flex;
            flex-direction:column;

            animation:fadeIn .2s ease;
        }

        .other{
            align-items:flex-start;
        }

        .self{
            align-items:flex-end;
        }

        .name{

            font-size:11px;

            font-weight:bold;

            margin-bottom:5px;

            color:white;
        }

        .bubble{

            padding:13px 16px;

            border-radius:18px;

            max-width:78%;

            word-break:break-word;

            line-height:1.4;

            font-size:14px;

            box-shadow:
            0 4px 12px rgba(0,0,0,0.08);
        }

        .other .bubble{

            background:white;

            color:#111827;

            border-top-left-radius:6px;
        }

        /* BUBBLE PENGIRIM LEBIH CERAH */

        .self .bubble{

            background:
            linear-gradient(
                135deg,
                #34d399,
                #10b981
            );

            color:white;

            border-top-right-radius:6px;

            box-shadow:
            0 8px 20px rgba(16,185,129,0.25);
        }

        .chat-footer{

            background:
            rgba(255,255,255,0.97);

            padding:14px;

            border-top:
            1px solid rgba(0,0,0,0.05);
        }

        .form-chat{

            display:flex;

            gap:10px;
        }

        input{

            border:
            2px solid #ccfbf1;

            outline:none;

            padding:13px 14px;

            border-radius:16px;

            background:white;

            font-size:13px;

            color:#111827;

            transition:.2s;

            box-shadow:
            0 3px 10px rgba(0,0,0,0.04);
        }

        input:focus{

            border-color:#14b8a6;

            box-shadow:
            0 0 0 4px rgba(20,184,166,0.15);
        }

        input::placeholder{

            color:#9ca3af;
        }

        #user{
            width:28%;
        }

        #message{
            flex:1;
        }

        button{

            border:none;

            border-radius:16px;

            background:
            linear-gradient(
                135deg,
                #10b981,
                #059669
            );

            color:white;

            font-weight:bold;

            padding:0 24px;

            cursor:pointer;

            transition:.2s;

            box-shadow:
            0 5px 15px rgba(16,185,129,0.25);
        }

        button:hover{

            transform:scale(1.03);

            background:
            linear-gradient(
                135deg,
                #34d399,
                #10b981
            );
        }

        @keyframes fadeIn{

            from{
                opacity:0;
                transform:translateY(8px);
            }

            to{
                opacity:1;
                transform:translateY(0);
            }
        }

    </style>

</head>

<body>

<div class="chat-container">

    <div class="chat-header">

        <h1>Realtime Chat</h1>

        <div class="status">

            <div class="status-dot"></div>

            Online

        </div>

    </div>

    <div id="chat">

        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="message other">

                <div class="name">
                    <?php echo e($msg->user); ?>

                </div>

                <div class="bubble">
                    <?php echo e($msg->message); ?>

                </div>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

    <div class="chat-footer">

        <form id="chat-form"
              class="form-chat">

            <input type="text"
                   id="user"
                   placeholder="Nama"
                   required>

            <input type="text"
                   id="message"
                   placeholder="Ketik pesan..."
                   required>

            <button type="submit">
                Kirim
            </button>

        </form>

    </div>

</div>

<script>

const chat =
document.getElementById('chat');

function scrollBottom()
{
    chat.scrollTop =
    chat.scrollHeight;
}

scrollBottom();

document.getElementById('chat-form')

.addEventListener('submit',

async function(e){

    e.preventDefault();

    let user =
    document.getElementById('user')
    .value
    .trim();

    let message =
    document.getElementById('message')
    .value
    .trim();

    if(!user || !message)
    {
        return;
    }

    await fetch('/send',{

        method:'POST',

        headers:{
            'Content-Type':'application/json',

            'X-CSRF-TOKEN':
            document.querySelector(
                'meta[name="csrf-token"]'
            ).content
        },

        body:JSON.stringify({
            user:user,
            message:message
        })

    });

    document.getElementById('message')
    .value='';

});

</script>

</body>

</html>
<?php /**PATH C:\Users\nandi\realtime-chat\resources\views/chat.blade.php ENDPATH**/ ?>