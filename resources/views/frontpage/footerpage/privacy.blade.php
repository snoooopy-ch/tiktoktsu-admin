@extends('layouts.front')

@section('title', 'プライバシーポリシー')

@section('styles')
    <style>
        #formerrors {
            display: none;
        }

    </style>
@endsection

@section('contents')
    <div class="content-body">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center mt-3 mb-2 text-primary mr-auto ml-auto">プライバシーポリシー</h1>
            </div>
            <div class="card-body">
                <p>TikTok通（以下「運営」といいます）では、運営の提供するサービスをご利用されるユーザーの個人情報の取扱について以下のとおり定め、個人情報の保護に努めてまいります。</p>
                <h6 class="term-header"><span>1.定義</span></h6>
                <p>このプライバシーポリシーにおいて、個人情報とは生存する個人に関する情報であり、当該情報に含まれる氏名、生年月日、IDその他の記述などにより、個人が特定できるものをいいます。</p><br>
                <h6 class="term-header"><span>2.個人情報の利用目的について</span></h6>
                <p>運営は、以下の利用目的のためにユーザーの個人情報を収集します。</p>
                <ul>
                    <li>運営サービスを提供するため</li>
                    <li>お客様への連絡、メールによる各種情報の提供を行うため</li>
                    <li>運営サービスの利用規約に違反する行為への対応及び当該違反行為の防止のため</li>
                    <li>運営サービスに関する運営の規約、ポリシー等の変更等をお客様に通知するため</li>
                    <li>紛争、訴訟などへの対応のため</li>
                    <li>運営サービスに関するご案内、お客様からのお問い合わせ等への対応のため</li>
                </ul>
                <h6 class="term-header"><span>3.個人情報の第三者提供について</span></h6>
                <p>法令に定める場合を除き、個人情報を事前に本人の同意を得ることなく第三者に提供することは行いません。
                </p><br>

                <h6 class="term-header"><span>4.個人情報の管理について</span></h6>
                <p>収集された個人情報は適切な管理の下で安全に蓄積・保管し、不正アクセス、紛失、 破壊、改竄、漏洩などの危険に対して適切に技術的、組織的な予防および対策を講じます。
                    個人情報もしくは情報システムを取り扱う業務を外部に委託する場合には、委託先の厳正な管理監督の下で行います。</p><br>

                <h6 class="term-header"><span>5.個人情報の開示・訂正・利用停止・消去・苦情について</span></h6>
                <p>運営は、本人が自己の個人情報について、開示・訂正・利用停止・消去などを求める権利を有していることを確認し、 「個人情報取扱に関するお問い合わせ窓口」を設け、これらの要求や苦情に対して速やかに対処します。
                </p><br>

                <h6 class="term-header"><span>取得したTikTokデータの取り扱いについて</span></h6>
                <p>運営はTikTokAPIを通じて取得したユーザー情報のうち、 運営サービスの運営に必要なユーザー情報のみ使用します。</p>
                <p>ランキング掲載の訂正、削除などをご希望される場合やその他本件情報に関しては、<a href="{{ route('contact.index') }}">お問い合わせ</a>ください。</p>
                <p>TikTokユーザー情報の開示・訂正・削除等にあたっては、当社所定の手続により、ご本人確認をさせていただきます。</p>

                <h6 class="term-header"><span>7.SSLセキュリティについて</span></h6>
                <p>当サイトは、お客様の個人情報を保護するために「SSL」に対応しています。</p>
                <p>SSLとは「Secure Socket Layer」の略で、SSLはWebサーバーとWebブラウザーとの間に暗号化し送受信できる通信方法です。</p>
                <p>セキュリティ機能に対応したブラウザを使用することで、お客様が入力される氏名や住所あるいは電話番号などの個人情報が自動的に暗号化されて送受信されるため、万が一、送受信データが第三者に傍受された場合でも、内容が盗み取られる心配はありません。
                </p>

                <h6 class="term-header"><span>8.Cookie（クッキー）について</span></h6>
                <p>当サイトは、「クッキー（Cookie）」と呼ばれる技術を利用したページがあります。</p>
                <p>クッキーとは、Webサーバーからお客様のWebブラウザに送信される小さなデータのことで、お客様のパソコンのハードディスクにファイルとして格納されるものもあります。</p>
                <p>Webサーバーは、このクッキーを参照することにより、お客様のパソコンを識別する事ができます。これによりお客様は効率的に当社webサイトを利用する事ができます。当サイトがクッキーとして送るファイルには個人を特定するような情報は含んでいません。
                </p><br>

                <a href="{{ route('term') }}">TikTok通利用規約</a><br>
                <a href="https://www.tiktok.com/legal/terms-of-service?lang=ja">TikTok利用規約</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
