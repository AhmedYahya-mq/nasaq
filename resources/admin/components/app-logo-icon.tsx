import { ImgHTMLAttributes } from "react";

interface AppLogoIconProps extends ImgHTMLAttributes<HTMLImageElement> {}

export default function AppLogoIcon(props: AppLogoIconProps) {
  // استخدم المسار المباشر من public
  const logoPath = "/favicon.ico";

  return <img src={logoPath} alt="App Logo" {...props} />;
}
