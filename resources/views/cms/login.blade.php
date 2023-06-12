<!DOCTYPE html>
<html lang="en">
	@include('cms.includes.head')

	<body>
		<div id="auth">
			<div class="row h-100">
				<div class="col-lg-5 col-12 d-flex">
					<div id="auth-left" class="w-100 my-auto">
						<div class="auth-logo mb-5 text-center">
							<a href="/cms/login">
								<img src="/img/logo-horizontal.png" alt="Logo" style="height: 100px;" />
							</a>
						</div>
						<form method="POST" action="/cms/login">
							@csrf
							<div class="form-group position-relative has-icon-left mb-4">
								<input type="email" class="form-control form-control-xl" name="email" placeholder="email"/>
								<div class="form-control-icon">
									<i class="bi bi-person"></i>
								</div>
							</div>
							<div class="form-group position-relative has-icon-left mb-4">
								<input type="password" class="form-control form-control-xl" name="password" placeholder="Password"/>
								<div class="form-control-icon">
									<i class="bi bi-shield-lock"></i>
								</div>
							</div>
							<button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
								Log in
							</button>
						</form>
					</div>
				</div>
				<div class="col-lg-7 d-none d-lg-block">
					<div id="auth-right" style="width: 100%; height: 100%;"></div>
				</div>
			</div>
		</div>
	</body>

	@include('cms.includes.script')
</html>