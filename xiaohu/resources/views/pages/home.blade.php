
<div class="container" ng-controller="HomeController">
	<div class="card margin-top">
		<h3>Latest</h3>
		<div class="hr"></div>
		<div class="item-set">
			<div ng-repeat="item in Timeline.data track by $index" class="item card-padding clear-float">
				<div ng-if="item.question_id" class="vote">
					<div ng-click="Timeline.vote({id:item.id, vote:1})" class="up"><i class="material-icons">keyboard_arrow_up</i> [:item.upvote_count:]</div>
					<div ng-click="Timeline.vote({id:item.id, vote:2})" class="down"><i class="material-icons">keyboard_arrow_down</i></div>
				</div>
				<div class="item-content">
					<div ng-if="item.question_id" class="content-act">[:item.user.username:] added Answer to </div>
					<div ng-if="!item.question_id" class="content-act">[:item.user.username:] added Question at [:item.updated_at:] </div>

					<div ng-if="item.question_id" class="title">
						<a ui-sref="question.detail({id: item.question.id})">[: item.question.title :]</a>
					</div>

					<div class="title">
						<a ui-sref="question.detail({id: item.id})">[:item.title:]</a>
					</div>

					<div class="content-owner"> 
						<a ui-sref="user({id: item.user_id})">[:item.user.username:] </a>
						<span class="desc">User Intro: [:item.user.intro:]</span> 
					</div>

					<div class="content-main"> 
						<a ui-sref="question.detail({id: item.question_id, answer_id: item.id})">[:item.content:] </a>
						
					</div>

					<div class="action-set">
						<div ng-click="item.show_comment = !item.show_comment" class="comment">Comment 
							<i ng-if="item.show_comment" class="material-icons">arrow_drop_up</i>
							<i ng-if="!item.show_comment" class="material-icons">arrow_drop_down</i>
						</div>
					</div>

					<div ng-if="item.show_comment" class="conmment-block">
						<div class="hr"></div>
						<div class="comment-item-set">
							<div class="comment-item clear-float">
								<div class="user">[: item.user.username :]</div>
								<div class="comment-content"> [: item.content :] </div>
							</div>
							<!-- <div class="comment-item clear-float">
								<div class="user">Ivony</div>
								<div class="comment-content"> 我认为Google应当和各个厂商合作积极推进Web技术的发展，而不是出于自己的目的积极推进标准化。可以说其实所谓的Web标准化目前在阻碍用户体验的提升，用个不恰当的例子，Web技术需要一次跨越性的发展，就像转基因技术一样，虽然会有公众的不理解和风险，但在这个上面的投入可以得到非常大的回报大大改善人类的生活质量。而传统的杂交育种技术，虽然有广泛的群众基础和较为容易被接受，却已经是穷途末路，能够带来的产量提升长远来看非常有限。 </div>
							</div>
							<div class="comment-item clear-float">
								<div class="user">Minko</div>
								<div class="comment-content"> javascript刚出来时，java正在风行全球，故为了扩大该语言知名度，命名为javascript </div>
							</div>
							<div class="comment-item clear-float">
								<div class="user">franky</div>
								<div class="comment-content"> 不要乱喷，CISC架构是不如RISC架构，但是事实上CPU内部是有指令译码器直接把CISC的指令译码成RISC的执行，所以这个问题只是译码由编译器完成还是由CPU完成，本质上并没有区别，而且x86的CISC架构在兼容和面向程序员友好方面优势巨大。当然目前的方向是虚拟机，这样一来下面的指令集是什么就更不重要了。
									
									Windows明显很差？如果真的很差为什么还有这么多人用？你以为用户和软件商都是傻子？你要说Win32 API很丑陋也算有道理，但那是历史余孽，显然微软是愿意革自己的命的，微软在2000年就推出了.NET代替原有的Windows API，现在XAML更是部署到了所有的平台。
									
									而Google呢？我只能说不能革自己命的公司迟早被别人革命。 </div>
							</div> -->
						</div>
					</div>
				</div>
				<div class="hr"></div>
			</div>
			<div ng-if="Timeline.pending" class="tac">Loading...</div>
			<div ng-if="Timeline.no_more_data" class="tac">No more data.</div>
		</div>
	</div>
</div>
